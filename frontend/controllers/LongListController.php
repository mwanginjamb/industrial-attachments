<?php

namespace frontend\controllers;

use frontend\models\Application;
use frontend\models\LongList;
use frontend\models\LongListApplication;
use frontend\models\LongListSearch;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use Yii;

/**
 * LongListController implements the CRUD actions for LongList model.
 */
class LongListController extends Controller
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
     * Lists all LongList models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LongListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LongList model.
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
     * Creates a new LongList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new LongList();

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
     * Updates an existing LongList model.
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
     * Deletes an existing LongList model.
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
     * Finds the LongList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LongList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LongList::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // Lanch Mail Client and Send the long list to selection committee members
    public function actionEmail($id)
    {
        $list = $this->findModel($id);
        if (!$list) {
            throw new NotFoundHttpException('The requested long list does not exist.');
        }

        // formulate the url
        $reviewUrl = Url::to(['/long-list/review', 'id' => $list->id], true);

        $emailBody = "Dear Colleagues,\n\n"
            . "Please access the attachee long list for your selection (shortlisting) review using the link below.\n\n"
            . "Review Link:\n"
            . $reviewUrl . "\n\n"
            . "Review applicants and mark successful candidates.\n\n"
            . "Regards,\n"
            . "HR Team";

        // Launch the default email client with the pre-filled email body
        $mailtoLink = 'mailto:'
            . '?subject='
            . rawurlencode('Attachee Long List Selection (Shortlisting) for Lot: ' . $list->lot->description)
            . '&body=' . urlencode($emailBody);
        return $this->redirect($mailtoLink);
    }

    // Review List - Selection List
    public function actionReview($id)
    {
        $longList = LongList::findOne($id);
        if (!$longList) {
            throw new NotFoundHttpException('The requested long list does not exist.');
        }


        $applications = Application::find()
            ->joinWith([
                'attachee',
                'status0',
                'lot',
            ])
            ->innerJoin(
                'long_list_application lla',
                'lla.application_id = application.id'
            )
            ->where([
                'lla.long_list_id' => $id
            ])
            ->orderBy([
                'application.id' => SORT_ASC
            ])
            ->all();

        $metrics = \Yii::$app->dashboard->metrics($id);


        return $this->render('review', [
            'longList' => $longList,
            'applications' => $applications,
            'metrics' => $metrics,
        ]);
    }

    // The ShortList Entries/ Items

    public function actionShortlist($id)
    {
        $longList = $this->findModel($id);
        if (!$longList) {
            throw new NotFoundHttpException('The requested long list does not exist.');
        }

        $applications = Application::find()
            ->joinWith([
                'attachee',
                'status0',
                'lot',
            ])
            ->innerJoin(
                'long_list_application lla',
                'lla.application_id = application.id'
            )
            ->where([
                'lla.long_list_id' => $id,
                'lla.shortlisted' => 1
            ])
            ->orderBy([
                'application.id' => SORT_ASC
            ])
            ->all();

            $metrics = \Yii::$app->dashboard->metrics($id);

        return $this->render('review', [
            'longList' => $longList,
            'applications' => $applications,
            'metrics' => $metrics,
        ]);

    }

    // Finalize the long list and mark it as closed
public function actionFinalize($id)
{
    $transaction = Yii::$app->db->beginTransaction();

    try {

        $longList = $this->findModel($id);

        if (!$longList) {
            throw new NotFoundHttpException(
                'The requested long list does not exist.'
            );
        }

        if ($longList->status === 'CLOSED') {

            Yii::$app->session->setFlash(
                'warning',
                'This shortlist has already been finalized.'
            );

            return $this->redirect([
                'shortlist',
                'id' => $longList->id
            ]);
        }

        // shortlisted candidates

        $items = LongListApplication::find()
            ->joinWith([
                'application.attachee'
            ])
            ->where([
                'long_list_id' => $longList->id,
                'shortlisted' => 1
            ])
            ->all();

        $selectedIds = [];

        foreach ($items as $item) {

            $selectedIds[] = $item->application_id;

            $application = $item->application;

            $application->status =
                Application::STATUS_SELECTED;

            if (!$application->save(false)) {
                throw new \RuntimeException(
                    'Failed updating selected application.'
                );
            }
        }

        // unsuccessful candidates

        $query = Application::find()
            ->where([
                'lot_id' => $longList->lot_id,
                'placement' => $longList->placement_id
            ]);

        if (!empty($selectedIds)) {

            $query->andWhere([
                'not in',
                'id',
                $selectedIds
            ]);
        }

        $unsuccessfulApplications = $query->all();

        foreach ($unsuccessfulApplications as $application) {

            $application->status =
                Application::STATUS_UNSUCCESSFUL;

            if (!$application->save(false)) {
                throw new \RuntimeException(
                    'Failed updating unsuccessful application.'
                );
            }
        }

        // close the review process

        $longList->status = 'CLOSED';
       // $longList->closed_at = time();
       // $longList->closed_by = Yii::$app->user->id;

        if (!$longList->save(false)) {
            throw new \RuntimeException(
                'Failed closing long list.'
            );
        }

        $transaction->commit();

        Yii::$app->session->setFlash(
            'success',
            'Shortlist finalized successfully.'
        );

    } catch (\Throwable $e) {

        $transaction->rollBack();

        Yii::$app->session->setFlash(
            'error',
            $e->getMessage()
        );
    }

    return $this->redirect([
        'shortlist',
        'id' => $id
    ]);
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
}
