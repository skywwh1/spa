<?php

namespace backend\controllers;

use backend\models\AdvertiserAuthToken;
use backend\models\ViewAdvertiserAuthToken;
use backend\models\ViewClickLog;
use backend\models\ViewFeedLog;
use common\models\Campaign;
use common\models\Channel;
use common\models\Deliver;
use common\models\Feed;
use common\models\IpTable;
use common\models\LogClick;
use common\models\LogEvent;
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
        $model = new Stream();
        $data = Yii::$app->request->getQueryParams();
        $allParameters = '';
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $allParameters .= $k . '=' . $v . '&';
            }
            $allParameters = chop($allParameters, '&');
        }
        if (!empty($allParameters)) {
            $model->all_parameters = $allParameters;
        }
        $model->click_uuid = uniqid() . uniqid() . mt_rand(1, 1000000);
        $model->click_id = isset($data['click_id']) ? $data['click_id'] : 0;
        $model->ch_id = isset($data['ch_id']) ? $data['ch_id'] : 0;
        $model->pl = isset($data['pl']) ? $data['pl'] : 0;
        $model->cp_uid = isset($data['cp_uid']) ? $data['cp_uid'] : 0;
        $model->ch_subid = isset($data['ch_subid']) ? $data['ch_subid'] : 0;
        $model->gaid = isset($data['gaid']) ? $data['gaid'] : 0;
        $model->idfa = isset($data['idfa']) ? $data['idfa'] : 0;
        $model->site = isset($data['site']) ? $data['site'] : 0;
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
        $model->ip = $clientIpAddress;
        $code = $this->restrictionTrack($model);
        if ($code !== 200) {
            return Json::encode(['error' => $this->_getStatusCodeMessage($code)]);
        }
        return $this->redirect($model->redirect);
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
     * @param Stream $model
     * @return string
     * @internal param $click_uuid
     * @internal param $ch_id
     */
    private function genAdvLink($camp, $model)
    {
        $paras = array(
            'click_id' => $model->click_uuid,
            'ch_id' => $model->ch_id,
            'idfa' => $model->idfa,
            'gaid' => $model->gaid,
            'site' => $model->site,
            'ch_subid' => $model->ch_subid
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
            $link .= 'click_id=' . $model->click_uuid; //默认
        }

        return $link;
    }

    /**
     * @param Stream $model
     * @return int
     * @throws \yii\base\InvalidConfigException
     * @internal param Campaign $campaign
     * @internal param Deliver $deliver
     */
    private function restrictionTrack(&$model)
    {
        //1.参数 click id，ch_id
//        $code = 200;
        if (!$model->validate() && $model->hasErrors()) {
            return 404;
        }
        $campaign = Campaign::findByUuid($model->cp_uid);
        if ($campaign === null) {
            return 500;
        }
        $deliver = Deliver::findIdentity($campaign->id, $model->ch_id);
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
        /**
         * test link
         */
        $cache = Yii::$app->cache;
        $test = $cache->get($model->ch_id . '');
        if ($test !== false) {
            $cache->set($model->ch_id, $model, 300);
        }
        //2.ip 限制
        $target = $campaign->target_geo;
        if (!empty($target) && $target !== 'Global') { //如果为空或者全球就限制
            $Info = \Yii::createObject([
                'class' => '\rmrevin\yii\geoip\HostInfo',
                'host' => $model->ip, // some host or ip
            ]);
            $geo = $Info->getCountryCode();   // US
            if (strpos($target, $geo) === false) {
                return 501;
            }
        }

        //正常0
        $model->adv_price = $campaign->adv_price;
        $model->pay_out = $deliver->pay_out;
        $model->daily_cap = $deliver->daily_cap;
        $model->discount = $deliver->discount;
        $link = $this->genAdvLink($campaign, $model);
        $model->redirect = $link;
        $model->is_count = 1;
//        $model->save();

        $click = new LogClick();
        $click->tx_id = empty($model->id) ? 0 : $model->id;
        $click->click_uuid = $model->click_uuid;
        $click->click_id = $model->click_id;
        $click->channel_id = $model->ch_id;
        $click->campaign_id = $campaign->id;
        $click->campaign_uuid = $model->cp_uid;
        $click->pl = $model->pl;
        $click->ch_subid = $model->ch_subid;
        $click->gaid = $model->gaid;
        $click->idfa = $model->idfa;
        $click->site = $model->site;
        $click->adv_price = $model->adv_price;
        $click->pay_out = $model->pay_out;
        $click->discount = $model->discount;
        $click->daily_cap = $model->daily_cap;
        $click->all_parameters = $model->all_parameters;
        $click->ip = $model->ip;
        $click->ip_long = ip2long($click->ip);
        $click->redirect = $model->redirect;
        $click->browser = empty($model->browser) ? 0 : $model->browser;
        $click->browser_type = empty($model->browser_type) ? 0 : $model->browser_type;
        $click->click_time = time();
        $click->save();

        //是否导量
        if ($deliver->is_redirect) {
            $redirect = RedirectLog::findIsActive($campaign->id, $model->ch_id);
            if (isset($redirect)) {
                $redirectCam = $redirect->campaignIdNew;
                $redirectLink = $this->genAdvLink($redirectCam, $model);
                $model->redirect = $redirectLink;
            }
        }


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
        $model->event_name = isset($data['event_name']) ? $data['event_name'] : null;
        $model->event_value = isset($data['event_value']) ? $data['event_value'] : null;

        if (!$model->validate()) {
//            $this->asJson($model->getErrors());
            $this->asJson(['status' => 'Missing Parameter']);
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


}
