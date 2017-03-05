<?php

namespace backend\controllers;

use backend\models\AdvertiserAuthToken;
use backend\models\ViewAdvertiserAuthToken;
use backend\models\ViewClickLog;
use backend\models\ViewFeedLog;
use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use common\models\IpTable;
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
                        'actions' => ['track', 'feed'],
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
        $model->click_uuid = uniqid() . uniqid();
        $model->click_id = isset($data['click_id']) ? $data['click_id'] : null;
        $model->ch_id = isset($data['ch_id']) ? $data['ch_id'] : null;
        $model->pl = isset($data['pl']) ? $data['pl'] : null;
        $model->cp_uid = isset($data['cp_uid']) ? $data['cp_uid'] : null;
        $model->ch_subid = isset($data['ch_subid']) ? $data['ch_subid'] : null;
        $model->gaid = isset($data['gaid']) ? $data['gaid'] : null;
        $model->idfa = isset($data['idfa']) ? $data['idfa'] : null;
        $model->site = isset($data['site']) ? $data['site'] : null;
        $model->ip = Yii::$app->request->getUserIP();
        $model->ip_long = ip2long(Yii::$app->request->getUserIP());
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
        $model->click_id = isset($data['click_id']) ? $data['click_id'] : null;
        $model->ch_id = isset($data['ch_id']) ? $data['ch_id'] : null;
        $model->auth_token = isset($data['auth_token']) ? $data['auth_token'] : null;
        $model->ip = Yii::$app->request->getUserIP();
        $model->ip_long = ip2long(Yii::$app->request->getUserIP());
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
        $test = $cache->get($model->ch_id);
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
        $model->save();
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
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}
