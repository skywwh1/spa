<?php

namespace backend\controllers;

use backend\models\StsForm;
use backend\models\TestLinkForm;
use common\models\Campaign;
use common\models\CampaignStsUpdate;
use common\models\ChannelBlack;
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
use yii\helpers\Json;

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
                            'go-create',
                            'second',
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
        return $this->renderAjax('view', [
            'model' => $this->findModel($campaign_id, $channel_id),
        ]);

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
            $blackChannels = [];
            foreach ($model->campaign_uuid as $campaign_id) {
                $camp = Campaign::findOne($campaign_id);
                if (!empty($camp->target_geo)) {
                    $targetGeos = explode(",",$camp->target_geo);
                }
                /**
                 * 1、首先根据campaign_id获得target_geo，advertiser
                 * 2、根据channel_id，target_geo，advertiser查询channel_black的是否有该
                 * 3、如果这条记录的
                */
                foreach ($model->channel as $channel_id) {
                    $deliver = new Deliver();
                    $deliver->campaign_id = $campaign_id;
                    $deliver->channel_id = $channel_id;
                    $deliver->campaign_uuid = isset($deliver->campaign) ? $deliver->campaign->campaign_uuid : "";
                    $deliver->channel0 = isset($deliver->channel) ? $deliver->channel->username : '';
                    $deliver->adv_price = isset($deliver->campaign) ? $deliver->campaign->adv_price : 0;
                    $deliver->pay_out = isset($deliver->campaign) ? $deliver->campaign->now_payout : 0;
                    $deliver->daily_cap = isset($deliver->campaign) ? $deliver->campaign->daily_cap : 0;
                    $deliver->kpi = isset($deliver->campaign) ? $deliver->campaign->kpi : '';
                    $deliver->note = isset($deliver->campaign) ? $deliver->campaign->note : '';
                    $deliver->others = isset($deliver->campaign) ? $deliver->campaign->others : '';
                    $deliver->discount = isset($deliver->channel)?$deliver->channel->discount:30;
                    $delivers[] = $deliver;

                    if (!empty($targetGeos)){
                        foreach ($targetGeos as $geo) {
                            $channel_black_list = ChannelBlack::find()
                                ->where(['channel_id' => $channel_id])
                                ->andWhere(['advertiser' => $camp->advertiser])
                                ->andFilterWhere(['like', 'geo', $geo])
                                ->asArray()
                                ->all();
                            if (!empty($channel_black_list)){
                                $channel_black_list['advertiser_name'] =  $camp->advertiser0->username;
                                $channel_black_list['channel_name'] = $deliver->channel->username;
                                array_push($blackChannels,$channel_black_list);
                            }
                        }
                    }
                }
            }

            $data = array();
            $return_msg = array();
            if (!empty($blackChannels)){
                foreach ($blackChannels as $black_channel) {
                    // $black_channel[0]不为空
                    if(is_array($black_channel[0]) && isset($black_channel[0])){
                        if ( $black_channel[0]['action_type'] == 0){
//                            $str = 'Target geos for '.$black_channel[0]['geo'].',advertisers for '.$black_channel['advertiser_name'].' ,'.$black_channel['channel_name'].' channels are labeled as Notice black channels!';
                            $str = 'Are you sure to S2S?Note:'.$black_channel[0]['note'];
                        }else{
//                            $str = 'Target geos for '.$black_channel[0]['geo'].',advertisers for '.$black_channel['advertiser_name'].', '.$black_channel['channel_name'].' channels are labeled as No S2S black channels!';
                            $str = 'Cannot S2S!!!Note:'.$black_channel[0]['note'];
                        }
                    }
                    $return_msg[] = $str;
                }
                $return_msg = implode(";",$return_msg);
//                return $return_msg;
            }
            return $this->render('second', [
                'delivers' => $delivers,
                'returnMsg' => empty($return_msg)?null:$return_msg
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
    public function actionGoCreate()
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
                    $deliver->kpi = isset($deliver->campaign) ? $deliver->campaign->kpi : '';
                    $deliver->note = isset($deliver->campaign) ? $deliver->campaign->note : '';
                    $deliver->others = isset($deliver->campaign) ? $deliver->campaign->others : '';
                    $delivers[] = $deliver;
                }
            }

            return  $this->render('second', [
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
    public function actionGetCreate()
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
                    $deliver->kpi = isset($deliver->campaign) ? $deliver->campaign->kpi : '';
                    $deliver->note = isset($deliver->campaign) ? $deliver->campaign->note : '';
                    $deliver->others = isset($deliver->campaign) ? $deliver->campaign->others : '';
                    $delivers[] = $deliver;
                }
            }

            return  $this->render('second', [
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
            // $model->is_send_create = 0;
            $model->status = 1;
            $model->end_time = null;
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

        if ($model->load(Yii::$app->request->post())) {
            $model->result = array();
            $channel = Channel::findChannelByName($model->channel);
            if (empty($channel)) {
                $model->result[] = "Can found channel";
                return $this->render('test_link', [
                    'model' => $model,
                ]);
            }
            $url = $model->tracking_link;
            $aa = explode('?', $url);
            $all_parameters = $aa[1];
            /**
             * $cache = Yii::$app->cache;
             * $cache->set($channel->id . '', 'test', 300);
             * $curl = new Curl();
             * $curl->setOptions(array(
             * CURLOPT_FOLLOWLOCATION => 1,
             * ));
             * $curl->get($model->tracking_link);
             * $headers = $curl->responseHeaders;
             * $clicks = '';
             * if (!empty($headers) && is_array($headers)) {
             * foreach ($headers as $k => $v) {
             * $clicks .= $v;
             * }
             * }
             * $model->result[] = 'Click response: ' . $clicks;
             * $data = $cache->get($channel->id . "");
             * $stream =Stream::getLatestClick($channel->id);
             * if ($data !== false && $data !== 'test') {
             * $stream = $data;
             * }
             * //            $cache->delete($channel->id . "");
             *
             * //            $stream = Stream::getLatestClick($channel->id);
             * if ($stream == null) {
             * $model->result[] = 'Please run tracking link on browser';
             * return $this->render('test_link', [
             * 'model' => $model,
             * ]);
             * } **/
            $link = Channel::genPostBack($channel->post_back, $all_parameters);
            $model->result[] = 'post back link: ' . $link;
            $curl = new Curl();
            if ($curl->get($link) !== false) {
                $model->result[] = 'Post back response: ' . $curl->response;
            } else {
                $model->result[] = 'Post back fail';
            }

        }
        return $this->render('test_link', [
            'model' => $model,
        ]);
    }
}
