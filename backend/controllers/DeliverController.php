<?php

namespace backend\controllers;

use backend\models\StsForm;
use backend\models\TestLinkForm;
use common\models\Campaign;
use common\models\CampaignStsUpdate;
use common\models\Channel;
use common\models\Deliver;
use common\models\DeliverSearch;
use common\models\Stream;
use linslin\yii2\curl\Curl;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * DeliverController implements the CRUD actions for Deliver model.
 */
class DeliverController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',
                            'create',
                            'update',
                            'view',
                            'delete',
                            'testlink',
                            'sts-create',
                            'pause',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Deliver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Deliver model.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionView($campaign_id, $channel_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($campaign_id, $channel_id),
        ]);

//        $searchModel = new DeliverSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Creates a new Deliver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StsForm();
        if ($model->load(Yii::$app->request->post())) {
            $delivers = [];
            foreach ($model->campaign_uuid as $campaign_id) {
                foreach ($model->channel as $channel_id) {
                    $deliver = new Deliver();
                    $deliver->campaign_id = $campaign_id;
                    $deliver->channel_id = $channel_id;
                    $deliver->campaign_uuid = isset($deliver->campaign) ? $deliver->campaign->campaign_uuid : "";
                    $deliver->channel0 = isset($deliver->channel) ? $deliver->channel->username : '';
                    $deliver->adv_price = isset($deliver->campaign) ? $deliver->campaign->adv_price : 0;
                    $deliver->pay_out = isset($deliver->campaign) ? $deliver->campaign->now_payout : 0;
                    $deliver->daily_cap = isset($deliver->campaign) ? $deliver->campaign->daily_cap : 0;
                    $deliver->note = isset($deliver->campaign) ? $deliver->campaign->note : '';
                    $delivers[] = $deliver;
                }
            }

            return $this->render('second', [
                'delivers' => $delivers,
            ]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Deliver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionStsCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $it = $request->post('Deliver');
        $campaign_id = $it['campaign_id'];
        $channel_id = $it['channel_id'];
        if (($model = $this->findUpdateModel($campaign_id, $channel_id)) === null) {
            $model = new Deliver();
        }
        $data = array();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->is_send_create = 0;
            if ($model->save()) {
                $campaign = Campaign::findOne($model->campaign_id);
                $channel = Channel::findOne($model->channel_id);
                $str = 'Campaign ' . $campaign->campaign_name . ' had been offer to ' . $channel->username;
                $data = ['Success' => $str];
            } else {
                $data = ['Success' => $model->getErrors()];
            }
        }
        return $data;
    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionUpdate($campaign_id, $channel_id)
    {
        $model = $this->findModel($campaign_id, $channel_id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionPause($campaign_id, $channel_id)
    {
//        $model = new CampaignStsUpdate();
//        $model->campaign_id = $campaign_id;
//        $model->channel_id = $channel_id;
//        if ($model->load(Yii::$app->request->post())) {
//            $model->create_time = time();
//            $model->effect_time = strtotime($model->effect_time);
//            $model->save();
//            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]);
//        } else {
//            return $this->renderAjax('pause', [
//                'model' => $model,
//            ]);
//        }
        $model = $this->findModel($campaign_id, $channel_id);

        if ($model->load(Yii::$app->request->post())) {
            $model->end_time = strtotime($model->end_time);
            $model->save();
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]);
        } else {
            return $this->renderAjax('pause', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Deliver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public
    function actionDelete($campaign_id, $channel_id)
    {
        $this->findModel($campaign_id, $channel_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Deliver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return Deliver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $channel_id)
    {
        if (($model = $this->findUpdateModel($campaign_id, $channel_id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Deliver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return Deliver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUpdateModel($campaign_id, $channel_id)
    {
        if (($model = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id])) !== null) {
            return $model;
        } else {
            return null;
        }
    }

    public function actionTestlink()
    {
        $model = new TestLinkForm();

//        if (Yii::$app->request->isAjax) {
        if ($model->load(Yii::$app->request->post())) {
            $model->result = array();
            $channel = Channel::findChannelByName($model->channel);
            if (empty($channel)) {
//                return "Can found channel";
                $model->result[] = "Can found channel";
                return $this->render('test_link', [
                    'model' => $model,
                ]);
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $model->tracking_link,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
//                CURLOPT_SSL_VERIFYPEER =>false,
                CURLOPT_SSL_VERIFYHOST =>0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: e687afd5-8c08-1f39-89bb-3c47e3c68830"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $model->result[] = $err;
            } else {
                $model->result[] = $response;
            }
//            $model->result[] = 'Superads response: ' . $curl->response . PHP_EOL;
////                echo 'Superads response: '.$curl->response.PHP_EOL;
//            $stream = Stream::getLatestClick($channel->id);
////                var_dump($stream->all_parameters);
////                die();
//            $link = Channel::genPostBack($channel->post_back, $stream->all_parameters);
//            $model->result[] = 'post back link: ' . $link . PHP_EOL;
////                echo 'post back link: '.$link.PHP_EOL;
////                var_dump($link);
//            $curl = new Curl();
//            if ($curl->get($link) !== false) {
////                    echo 'Channel response: '.$curl->response.PHP_EOL;
////                    var_dump($curl);
////                    return "Post back success";
//                $model->result[] = 'Channel response: ' . $curl->response . PHP_EOL;
//            } else {
//                $model->result[] = 'Channel response: none' . PHP_EOL;
//            }


//            $model->result = $message;
        }
        return $this->render('test_link', [
            'model' => $model,
        ]);
    }
}
