<?php

namespace frontend\controllers;

use frontend\models\Lot;
use frontend\models\LotSearch;
use frontend\models\PlacementArea;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LotController implements the CRUD actions for lot model.
 */
class LotController extends Controller
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
                    'class' => VerbFilter::class,
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
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['logout', 'signup', 'index'],
                    'rules' => [
                        [
                            'actions' => ['signup'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'actions' => ['logout', 'index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ],
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
     * Lists all lot models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LotSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDashboard()
    {
        $this->layout = 'dashboard';
        return $this->render('dashboard');
    }

    /**
     * Displays a single lot model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Lot applications
        $applications = \frontend\models\Application::find()
            ->joinWith('lot')
            ->joinWith('status0')
            ->joinWith('attachee')
            ->where(['lot_id' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        // Yii::$app->utility->printrr($applications);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'applications' => $applications
        ]);
    }

    /**
     * Creates a new lot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Lot();

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
     * Updates an existing lot model.
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
     * Deletes an existing lot model.
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
     * Finds the lot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Lot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lot::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionCommit()
    {
        try {
            $endpoint = Yii::$app->request->post('service');
            $field = Yii::$app->request->post('name');
            $value = Yii::$app->request->post('value');
            $id = Yii::$app->request->post('key');

            $payload = [
                $field => $value,
                'id' => $id
            ];

            $client = new Client([
                'transport' => CurlTransport::class,
            ]);

            $request = $client->createRequest()
                ->setMethod('PUT')
                ->setUrl($endpoint)
                ->addHeaders(['Content-Type' => 'application/json'])
                ->setFormat(Client::FORMAT_JSON)  // Ensures JSON encoding for request
                ->setData($payload)
                ->setOptions([
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ]);

            $response = $request->send();
            Yii::info('Raw response content: ' . $response->content, 'api_debug');
            if ($response->isOk) { // Check if the response status is 200-299
                return $response->data; // Return the relevant response data
            } else {
                // Log error details if needed and return a clear message
                return [
                    'status' => $response->statusCode,
                    'error' => $response->data ?? 'Unexpected error occurred'
                ];
            }
        } catch (\Exception $e) {
            return "HTTP request failed with error: " . $e->getMessage();
        }

    }

    // Possible placement options (centres) for an attachee
    public function actionPlacements()
    {
        $placements = PlacementArea::find()->all();
        $data = ArrayHelper::map($placements, 'id', 'name');
        return $data;
    }

}
