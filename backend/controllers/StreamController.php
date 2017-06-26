<?php

namespace backend\controllers;

use backend\models\AdvertiserAuthToken;
use backend\models\ViewAdvertiserAuthToken;
use backend\models\ViewClickLog;
use backend\models\ViewFeedLog;
use common\models\Campaign;
use common\models\CampaignSubChannelLog;
use common\models\CampaignSubChannelLogRedirect;
use common\models\Deliver;
use common\models\Feed;
use common\models\IpTable;
use common\models\LogClick;
use common\models\LogClickCount;
use common\models\LogEvent;
use common\models\LogSpaMapping;
use common\models\RedirectLog;
use common\models\Stream;
use common\models\StreamSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * StreamController implements the CRUD actions for Stream model.
 */
class StreamController extends Controller
{
    public $layout = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['track', 'feed', 'event'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Stream models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'admin_layout';
        $searchModel = new StreamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stream model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'admin_layout';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Stream model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stream the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stream::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTrack()
    {
        $click = new LogClick();

        $data = Yii::$app->request->getQueryParams();
        $allParameters = '';
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $allParameters .= $k . '=' . $v . '&';
            }
            $allParameters = chop($allParameters, '&');
        }
        if (!empty($allParameters)) {
            $click->all_parameters = $allParameters;

        }
        $click->click_uuid = uniqid() . uniqid() . mt_rand(1, 1000000);
        $click->click_id = isset($data['click_id']) ? $data['click_id'] : 0;
        $click->channel_id = isset($data['ch_id']) ? $data['ch_id'] : 0;
        $click->pl = isset($data['pl']) ? $data['pl'] : 0;
        $click->campaign_uuid = isset($data['cp_uid']) ? $data['cp_uid'] : 0;
        $click->ch_subid = isset($data['ch_subid']) ? $data['ch_subid'] : 0;
        $click->gaid = isset($data['gaid']) ? $data['gaid'] : 0;
        $click->idfa = isset($data['idfa']) ? $data['idfa'] : 0;
        $click->site = isset($data['site']) ? $data['site'] : 0;
//        $clientIpAddress = Yii::$app->request->getUserIP();
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ips = explode(', ', $clientIpAddress);
            if (count($ips) > 1) {
                $clientIpAddress = $ips[1];
            }
        } else {
            $clientIpAddress = $_SERVER['REMOTE_ADDR'];
        }
        $click->ip = $clientIpAddress;
        $click->ip_long = ip2long($click->ip);
        $code = $this->restrictionTrack($click);
        if ($code !== 200) {
            return Json::encode(['error' => $this->_getStatusCodeMessage($code)]);
        }
        return $this->redirect($click->redirect);
    }

    public function actionFeed()
    {
        $model = new Feed();
        $data = Yii::$app->request->getQueryParams();
        $allParameters = '';
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $allParameters .= $k . '=' . $v . '&';
            }
            $allParameters = chop($allParameters, '&');
        }
        $model->click_id = isset($data['click_id']) ? $data['click_id'] : 0;
        $model->ch_id = isset($data['ch_id']) ? $data['ch_id'] : 0;
        $model->auth_token = isset($data['auth_token']) ? $data['auth_token'] : 0;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ips = explode(', ', $clientIpAddress);
            if (count($ips) > 1) {
                $clientIpAddress = $ips[1];
            }
        } else {
            $clientIpAddress = $_SERVER['REMOTE_ADDR'];
        }
        $model->ip = $clientIpAddress;
        $model->all_parameters = $allParameters;
        $code = $this->restrictionFeed($model);
        if ($code !== 200) {
            return Json::encode(['error' => $this->_getAdvCodeMessage($code)]);
        }
        if (!empty($allParameters)) {
            $model->save();
        }
        return Json::encode(['success' => $data]);
    }

    /**
     * 替换广告组的参数，目前只有 click_id 和ch_id
     * @param Campaign $camp
     * @param LogClick $click
     * @return string
     * @internal param $click_uuid
     * @internal param $ch_id
     */
    private function genAdvLink($camp, $click)
    {
        $paras = array(
            'click_id' => $click->click_uuid,
            'ch_id' => $click->channel_id,
            'idfa' => $click->idfa === 0 ? '' : $click->idfa,
            'gaid' => $click->gaid === 0 ? '' : $click->gaid,
            'site' => $click->site,
            'ch_subid' => $click->ch_subid
        );

        $link = $camp->adv_link;
        if (strpos($link, '?') !== false) {
            $link .= '&';
        } else {
            $link .= '?';
        }
        $post_param = $camp->advertiser0->post_parameter;
        if (!empty($post_param)) {
            $post_param = str_replace('{click_id}', $paras['click_id'], $post_param);
            $post_param = str_replace('{ch_subid}', $paras['ch_subid'], $post_param);
            $post_param = str_replace('{ch_id}', $paras['ch_id'], $post_param);
            $post_param = str_replace('{idfa}', $paras['idfa'], $post_param);
            $post_param = str_replace('{gaid}', $paras['gaid'], $post_param);
            $post_param = str_replace('{site}', $paras['site'], $post_param);
            $link .= $post_param;
        } else {
            $link .= 'click_id=' . $click->click_uuid; //默认
        }

        return $link;
    }

    /**
     * @param LogClick $click
     * @return int
     * @throws \yii\base\InvalidConfigException
     * @internal param Campaign $campaign
     * @internal param Deliver $deliver
     */
    private function restrictionTrack(&$click)
    {

        $campaign = Campaign::findByUuid($click->campaign_uuid);
        if ($campaign === null) {
            return 500;
        }
        $deliver = Deliver::findIdentity($campaign->id, $click->channel_id);
        if ($deliver === null) {
            return 500;
        }
        //3.单子状态
        if ($deliver->status !== 1) {
            return 403;
        }
        if ($campaign->status !== 1) {
            return 403;
        }

        //对于停了的子渠道就返回405，is_effected=1表示子渠道是被手动暂停的
        if (!empty($click->ch_subid)) {
            $sub_channel = CampaignSubChannelLog::findOne(['is_effected' => 1, 'campaign_id' => $campaign->id, 'channel_id' => $click->channel_id, 'sub_channel' => $click->ch_subid]);
            if (!empty($sub_channel)) {
                return 405;
            }
        }
        /**
         * test link
         */
//        $cache = Yii::$app->cache;
//        $test = $cache->get($model->ch_id . '');
//        if ($test !== false) {
//            $cache->set($model->ch_id, $model, 300);
//        }
//        //2.ip 限制
        $target = $campaign->target_geo;
        if (!empty($target) && $target !== 'Global') { //如果为空或者全球就限制
            $Info = \Yii::createObject([
                'class' => '\rmrevin\yii\geoip\HostInfo',
                'host' => $click->ip, // some host or ip
            ]);
            $geo = $Info->getCountryCode();   // US
            if (strpos($target, $geo) === false) {
                return 501;
            }
        }

        //正常0
        $click->campaign_id = $campaign->id;
        $click->adv_price = $campaign->adv_price;
        $click->pay_out = $deliver->pay_out;
        $click->daily_cap = $deliver->daily_cap;
        $click->discount = $deliver->discount;
        $link = $this->genAdvLink($campaign, $click);
        $click->redirect = $link;
        $click->click_time = time();

        if (!$click->validate() && $click->hasErrors()) {
            return 404;
        }
        $click->save();
        $map = LogSpaMapping::findOne(['spa_campaign_id' => $click->campaign_id]);
        if (empty($map)) {
            //是否导量
            if ($deliver->is_redirect) {
                $redirect = RedirectLog::findIsActive($campaign->id, $click->channel_id);
                if (isset($redirect)) {
                    $redirectCam = $redirect->campaignIdNew;
                    $redirectLink = $this->genAdvLink($redirectCam, $click);
                    $click->redirect = $redirectLink;
                }
            }

            //子渠道是否导量
            if (!empty($click->ch_subid)) {
                $sub_redirect = CampaignSubChannelLogRedirect::findIsActive($campaign->id, $click->channel_id, $click->ch_subid);

                if (!empty($sub_redirect)) {
                    $redirectCam = $sub_redirect->campaignIdNew;
                    $redirectLink = $this->genAdvLink($redirectCam, $click);
                    $click->redirect = $redirectLink;
                }
            }
        } else {
            $click->redirect = "http://stream.traffic.red/track/pub?de=" . $map->tr_de_id . '&click_id=' . $click->click_uuid;
        }

//        $this->countClick($click);

        return 200;
    }

    /**
     * @param Feed $model
     * @return int
     */
    private function restrictionFeed(&$model)
    {
        return 200;
        $code = 200;
        //1.token 限制
        $token = $model->auth_token;
        $adt = ViewAdvertiserAuthToken::findOne(['auth_token' => $token]);
        if ($adt === null) {
            $code = 400;
            return $code;
        }
        //2.click uuid 限制
        $clickuuid = ViewClickLog::findOne(['click_uuid' => $model->click_id]);
        if ($clickuuid === null) {
            $code = 401;
            return $code;
        }
        //3.ip 限制
        $ip = IpTable::findOne(['value' => $model->ip]);
        if ($ip === null) {
            $code = 402;
            return $code;
        }
        //4.唯一限制
        $feed = ViewFeedLog::findOne(['auth_token' => $token, 'click_id' => $model->click_id]);
        if ($feed !== null) {
            $code = 403;
            return $code;
        }

        return $code;
    }

    private function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'IP address not allow',
            403 => 'Campaign paused',
            404 => 'Missing parameters',
            405 => 'Publisher paused',
            500 => 'Can`t found the campaign',
            501 => 'Your country is not allow!',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function _getAdvCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Invalid token',
            401 => 'Invalid click id',
            402 => 'IP address not allow',
            403 => 'Duplicate transaction',
            404 => 'Missing parameters',
            500 => 'Can`t found the campaign',
            501 => 'Your country is not allow!',
            502 => 'Channel does not exist!',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function actionEvent()
    {
        $model = new LogEvent();
        $data = Yii::$app->request->getQueryParams();
        $model->click_uuid = isset($data['click_id']) ? $data['click_id'] : null;
        $model->channel_id = isset($data['ch_id']) ? $data['ch_id'] : null;
        $model->auth_token = isset($data['auth_token']) ? $data['auth_token'] : null;
        $model->ip = Yii::$app->request->getUserIP();
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ips = explode(', ', $clientIpAddress);
            if (count($ips) > 1) {
                $clientIpAddress = $ips[1];
            }
        } else {
            $clientIpAddress = $_SERVER['REMOTE_ADDR'];
        }
        $model->ip = $clientIpAddress;
        $model->ip_long = ip2long($model->ip);
        $model->event_name = isset($data['event_name']) ? $data['event_name'] : 0;
        $model->event_value = isset($data['event_value']) ? $data['event_value'] : 0;

        if (!$model->validate()) {
            $this->asJson($model->getErrors());
//            $this->asJson(['status' => 'Missing Parameter']);
        } else {
            if ($this->restrictionEvent($model) != 200) {
                $this->asJson($this->_getAdvCodeMessage($this->restrictionEvent($model)));
            } else {
                $model->save();
                $this->asJson(['status' => 'success']);
            }
        }
    }

    /**
     * @param LogEvent $model
     * @return int
     */
    private function restrictionEvent($model)
    {
        $code = 200;
        //1.token 限制
//        $token = $model->auth_token;
//        $adt = ViewAdvertiserAuthToken::findOne(['auth_token' => $token]);
//        if ($adt === null) {
//            $code = 400;
//            return $code;
//        }
//        //2.click uuid 限制
//        $clickuuid = ViewClickLog::findOne(['click_uuid' => $model->click_uuid]);
//        if ($clickuuid === null) {
//            $code = 401;
//            return $code;
//        }
//        //3 channel
//        $channel = Channel::findIdentity($model->channel_id);
//        if ($channel === null) {
//            $code = 502;
//            return $code;
//        }
        return $code;
    }

    /**
     * @param LogClick $logClick
     */
    private function countClick($logClick)
    {
        $hourly_str = date('Y-m-d H:00', $logClick->click_time);
        $hourly = strtotime($hourly_str);
        $clickCount = LogClickCount::findCampaignClick($logClick->campaign_id, $logClick->channel_id, $hourly);
        $clickCount->clicks += 1;
        $ip = LogClick::findOne(['campaign_id' => $logClick->campaign_id, 'channel_id' => $logClick->channel_id, 'ip_long' => $logClick->ip_long]);
        if (empty($ip)) {
            $clickCount->unique_clicks += 1;
        }
        $clickCount->save();
    }

}
