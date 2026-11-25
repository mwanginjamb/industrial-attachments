<?php

namespace frontend\controllers;

use frontend\models\Application;
use frontend\models\ApplicationSearch;
use frontend\models\Attachee;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['logout', 'signup', 'apply', 'create', 'update', 'view', 'index'],
                    'rules' => [
                        [
                            'actions' => ['signup'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'actions' => ['logout', 'apply', 'create', 'update', 'view', 'index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'contentNegotiator' => [
                    'class' => ContentNegotiator::class,
                    'only' => ['commit', 'placements'],
                    'formatParam' => '_format',
                    'formats' => [
                        'application/json' => \yii\web\Response::FORMAT_JSON
                    ]
                ],
            ]
        );
    }

    public function beforeAction($action)
    {

        $ExceptedActions = [
            'commit',
            'placements'
        ];

        if (in_array($action->id, $ExceptedActions)) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Application models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
<<<<<<< HEAD
=======
        $attachee = \frontend\models\Attachee::findOne(['user_id' => Yii::$app->user->id]);
        $total_templates = \frontend\models\AttacheeDocumentsTemplates::getTotalTemplates();
        $total_attachee_documents = \frontend\models\AttacheeDocuments::getDocumentsCount($attachee->attachee_reference);
        $attachedDocuments = \frontend\models\AttacheeDocumentsTemplates::find()->With([
            'attacheeDocument' => function ($query) {
                $query->andWhere(['not', ['path' => null]])
                    ->andWhere(['not', ['path' => '']])
                    ->andWhere(['attachee_id' => Yii::$app->user->identity->attachee->attachee_reference]);
            }
        ])->all();

        $applications = \frontend\models\Application::find()
            ->joinWith('lot')
            ->joinWith('status0')
            ->joinWith('attachee')
            ->where(['attachee_id' => $attachee->id])
            ->asArray()
            ->limit(4)
            ->all();

        $icons = [
            1 => 'description',
            2 => 'school',
            3 => 'badge',
            4 => 'health_and_safety'
        ];

        $StatusIcons = [
            Application::STATUS_SUBMITTED => 'hourglass_top',
            Application::STATUS_UNDER_REVIEW => 'search',
            Application::STATUS_ACCEPTED => 'check_circle',
            Application::STATUS_PLACED => 'verified',
        ];
>>>>>>> Featshortlist
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Application();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * A user with a complete Attachee profile applying for a job
     */

    public function actionApply($lot)
    {
<<<<<<< HEAD
=======
        // check lot exists
        $lot = \frontend\models\Lot::findOne(['id' => $lot]);
        if (!$lot) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested lot does not exist.'));
        }

        // check if lot is Active
        if (!$lot->isActive) {
            Yii::$app->session->addFlash('error', 'The application period for this lot is closed.');
            return $this->redirect(['site/index']);
        }

>>>>>>> Featshortlist
        // check if the user has a complete Attachee profile
        $attachee = Attachee::findOne(['user_id' => Yii::$app->user->id]);



        // check if an application already exists for this attachee + lot
        $existing = Application::findOne([
            'attachee_id' => $attachee->id,
            'lot_id' => $lot->id,
        ]);

        if ($existing) {
            Yii::$app->session->addFlash('error', 'You have already applied for this lot.');
            return $this->redirect(['site/index']);
        }

        // if not, redirect to the Attachee profile page
        if (!$attachee) {
            // add flash message for profile completion
            Yii::$app->session->setFlash('info', 'Please complete your profile before applying for Industrial Attachment.');
            // do minimal profile save  - save the user id
            $attachee = $this->saveAttacheeProfile(Yii::$app->user->id);
            // redirect to attache update page
            return $this->redirect(['attachee/update', 'id' => $attachee->id]);
        }
<<<<<<< HEAD
=======

        // Validate the attachee profile completeness - check if the required fields are filled
        if ($attachee && !\frontend\models\Attachee::isComplete($attachee)) {
            Yii::$app->session->setFlash('info', 'Please complete your profile information before applying for Industrial Attachment.');
            return $this->redirect(['attachee/update', 'id' => $attachee->id]);
        }


        // documents validation

        $total_templates = \frontend\models\AttacheeDocumentsTemplates::getTotalTemplates();
        $total_attachee_documents = \frontend\models\AttacheeDocuments::getDocumentsCount($attachee->attachee_reference);

        if ($total_templates > $total_attachee_documents) {
            Yii::$app->session->setFlash('info', 'Please upload all required documents before applying for Industrial Attachment.');
            return $this->redirect(['attachee/update', 'id' => $attachee->id]);
        }


>>>>>>> Featshortlist
        // if yes, make an application entry
        $application = new Application();
        $application->attachee_id = $attachee->id;
        $application->lot_id = $lot;
        if ($application->save()) {
            // redirect to site/index - dashboard
            Yii::$app->session->addFlash('success', 'Application submitted successfully');
        } else {
            Yii::$app->session->addFlash('error', 'Application submission failed');
        }
        return $this->redirect(['site/index']);
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    // save attachee minimal profile
    protected function saveAttacheeProfile($userId)
    {
        $attachee = new Attachee();
        $attachee->user_id = $userId;
        if ($attachee->save(false)) {
            return $attachee;
        }
        return null;
    }



}
