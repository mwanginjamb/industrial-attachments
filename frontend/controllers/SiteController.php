<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\User;
use yii\helpers\Url;

use frontend\models\Attachee;
use frontend\models\AttacheeDocumentsTemplates;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'index', 'listing'],
                'rules' => [
                    [
                        'actions' => ['signup', 'listing'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'listing'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            // content negotiator behavior
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'only' => ['commit', 'placements', 'upload'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        $ExceptedActions = [
            'upload',
        ];

        if (in_array($action->id, $ExceptedActions)) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $this->layout = 'dashboard';

        // check if role is staff , then redirect to settings
        if (Yii::$app->user->can('staff')) {
            return $this->redirect(\yii\helpers\Url::to(['lot/index']));
        }

        if (Yii::$app->user->can('attachee')) {
            return $this->redirect(\yii\helpers\Url::to(['site/listing']));
        }
        $attachee = \frontend\models\Attachee::findOne(['user_id' => Yii::$app->user->id]);
        $total_templates = \frontend\models\AttacheeDocumentsTemplates::getTotalTemplates();
        $total_attachee_documents = Yii::$app->user->identity->attachee ? \frontend\models\AttacheeDocuments::getDocumentsCount($attachee->attachee_reference) : 0;
        $attachedDocuments = Yii::$app->user->identity->attachee ? \frontend\models\AttacheeDocumentsTemplates::find()->With([
            'attacheeDocument' => function ($query) {
                $query->andWhere(['not', ['path' => null]])
                    ->andWhere(['not', ['path' => '']])
                    ->andWhere(['attachee_id' => Yii::$app->user->identity->attachee->attachee_reference]);
            }
        ])->all() : [];

        $applications = (Yii::$app->user->identity->attachee) ? \frontend\models\Application::find()
            ->joinWith('lot')
            ->joinWith('status0')
            ->joinWith('attachee')
            ->where(['attachee_id' => $attachee->id])
            ->asArray()
            ->limit(4)
            ->all() : 0;

        $icons = [
            1 => 'description',
            2 => 'school',
            3 => 'badge',
            4 => 'health_and_safety'
        ];

        //  Yii::$app->utility->printrr($applications);

        return $this->render('index', [
            'model' => $attachee,
            'docTemplates' => $attachedDocuments,
            'lots' => \frontend\models\Lot::find()->active()->all(),
            'total_templates' => $total_templates,
            'total_attachee_documents' => $total_attachee_documents,
            'icons' => $icons,
            'applications' => $applications
        ]);
    }

    public function actionListing()
    {

        $this->layout = 'dashboard';
        // Get all lots with their related applications and applicants
        $lots = \frontend\models\Lot::find()->orderByActive()->all();
        return $this->render('listing', [
            'lots' => $lots
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'auth';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'auth';
        $model = new SignupForm();
        if (Yii::$app->request->get('sreg')) {
            $model->scenario = 'staff';
            $model->staffRegistration = true;
        }
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }


        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'auth';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $this->layout = 'auth';
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionUpload()
    {
        // Upload
        if (Yii::$app->request->isPost) {
            $attachee_id = Yii::$app->request->post('attachee_reference');
            $document_type = Yii::$app->request->post('document_type');
            // implement updateOrCreate pattern
            $model = \frontend\models\AttacheeDocuments::findOne([
                'attachee_id' => $attachee_id,
                'document_type' => $document_type,
            ]) ?? new \frontend\models\AttacheeDocuments([
                    'attachee_id' => $attachee_id,
                    'document_type' => $document_type,
                ]);

            $model->save();

            $parentDocument = Attachee::findOne(['attachee_reference' => Yii::$app->request->post('attachee_reference')]);
            // Yii::$app->utility->printrr($parentDocument);
            $metadata = [];
            if (is_object($parentDocument) && isset($parentDocument->attachee_reference)) {
                $metadata = [
                    'Attachee' => $parentDocument->attachee_reference,
                    'AttacheeName' => $parentDocument->user_id,
                    'DocumentType' => AttacheeDocumentsTemplates::findOne(['id' => Yii::$app->request->post('document_type')])->document_description,
                ];
            }
            Yii::$app->session->set('metadata', $metadata);

            // Create a directory to store attachee docs - attachee_Reference
            $folder = Yii::$app->sharepoint->createFolder($parentDocument->attachee_reference);
            //Yii::$app->utility->printrr($folder);

            $attachmentName = $_FILES['attachment']['name'];
            $file = $_FILES['attachment']['tmp_name'];
            $binary = file_get_contents($file);
            //Return JSON
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($binary) {
                // Upload to sharepoint
                $spResult = Yii::$app->sharepoint->attach_toLibrary(env('SP_LIBRARY') . '\\' . $parentDocument->attachee_reference, $binary, $attachmentName, $metadata = [], TRUE);
                Yii::$app->session->set('SP_PATH', $spResult);
                return [
                    'status' => 'success',
                    'message' => 'File Uploaded Successfully. :- ' . $spResult,
                    'filePath' => $spResult
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Could not upload file at the moment.'
                ];
            }
        }


        // Update  - attacheDocument Table Get Request
        if (Yii::$app->request->isGet) {
            $fileName = basename(Yii::$app->request->get('filePath'));


            $model = \frontend\models\AttacheeDocuments::findOne([
                'attachee_id' => Yii::$app->request->get('No'),
                'document_type' => Yii::$app->request->get('documentType'),
            ]) ?? new \frontend\models\AttacheeDocuments([
                    'attachee_id' => Yii::$app->request->get('No'),
                    'document_type' => Yii::$app->request->get('documentType'),
                ]);
            $model->attributes = [
                'path' => Yii::$app->request->get('filePath')
            ];
            $result = $model->save();



            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($result) {
                return ['status' => 'success', 'message' => 'Document saved successfully'];
            } else {
                return ['status' => 'error', 'message' => json_encode($model->getErrors())];
            }
        }
    }


    // Read - attacheDocument Table Get Request and return base64 encoded content to view
    public function actionRead($link, $profileId)
    {
        $link = Yii::$app->request->get('link');
        $file = Yii::$app->sharepoint->getBinary($link);
        $model = Attachee::findOne(['id' => $profileId]);
        return $this->render('read', [
            'content' => $file,
            'profileId' => $profileId,
            'model' => $model
        ]);
    }

    public function actionUsers()
    {
        $users = User::find()->select(['id', 'username', 'email', 'created_at', 'status'])->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('users', [
            'users' => $users
        ]);
    }

    public function actionLookupEmployee($employeeNumber)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new SignupForm();

        $assignees = $model->fetchAssignees();

        foreach ($assignees as $key => $displayName) {

            $parts = array_map('trim', explode('-', $key, 3));

            if (count($parts) < 3) {
                continue;
            }

            [$empno, $email, $fullnames] = $parts;

            if ($empno === trim($employeeNumber)) {

                $username = strstr($email, '@', true);

                return [
                    'success' => true,
                    'username' => strtolower($username),
                    'email' => strtolower($email),
                    'displayName' => $displayName,
                    'fullNames' => $fullnames
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Employee not found'
        ];
    }
}
