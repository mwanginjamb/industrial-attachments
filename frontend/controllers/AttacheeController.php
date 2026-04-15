<?php

namespace frontend\controllers;

use frontend\models\Attachee;
use frontend\models\AttacheeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use frontend\models\AttacheeDocuments;
use frontend\models\AttacheeDocumentsTemplates;

use Yii;

/**
 * AttacheeController implements the CRUD actions for Attachee model.
 */
class AttacheeController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
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
     * Lists all Attachee models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AttacheeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Attachee model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Attachee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Attachee();

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
     * Updates an existing Attachee model.
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
            'fileModel' => new \frontend\models\File(),
            'docTemplates' => \frontend\models\AttacheeDocumentsTemplates::find()->With(['attacheeDocument' => function ($query) {
                $query->andWhere(['not', ['path' => null]])
                    ->andWhere(['not', ['path' => '']])
                    ->andWhere(['not', ['attachee_id' => null]])
                    ->andWhere(['not', ['attachee_id' => '']]);
            }])->all(),
        ]);
    }

    /**
     * Deletes an existing Attachee model.
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
     * Finds the Attachee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Attachee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachee::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionUpload()
    {

        $targetPath = '';
        if ($_FILES) {
            $uploadedFile = $_FILES['attachment']['name'];
            list($pref, $ext) = explode('.', $uploadedFile);
            $targetPath = './plogs/' . Yii::$app->utility->processPath($pref) . '.' . $ext; // Create unique target upload path
            $attachmentName = Yii::$app->utility->processPath($pref) . '.' . $ext;
            // Create upload directory if it dnt exist.
            if (!is_dir(dirname($targetPath))) {
                FileHelper::createDirectory(dirname($targetPath));
                chmod(dirname($targetPath), 0755);
            }
        }

        // Upload
        if (Yii::$app->request->isPost) {
            $DocumentService = new AttacheeDocuments();
            $DocumentService->attachee_id = Yii::$app->request->post('attachee_reference');
            $DocumentService->document_type = Yii::$app->request->post('document_type');
            $DocumentService->save();
            
            $parentDocument = Attachee::findOne(['attachee_reference' => Yii::$app->request->post('attachee_reference')])   ;
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

           // $AttacheDocument = AttacheeDocuments::findOne(['attachee_id' => Yii::$app->request->get('No')]);
           $AttacheDocument = new AttacheeDocuments();
           $AttacheDocument->attachee_id = Yii::$app->request->get('No');
           $AttacheDocument->path = Yii::$app->request->get('filePath');
           $AttacheDocument->document_type = Yii::$app->request->get('documentType');
            
           $result = $AttacheDocument->save();

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($result) {
                return ['status' => 'success', 'message' => 'Document saved successfully'];
            } else {
                return ['status' => 'error', 'message' => json_encode($AttacheDocument->getErrors())];
            }
        }
    }

    // Read - attacheDocument Table Get Request and return base64 encoded content to view
    public function actionRead($link,$profileId)
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
}
