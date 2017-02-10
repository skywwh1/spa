<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use Yii;
use common\models\Stream;
use common\models\StreamSearch;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                        'actions' => ['index','view'],
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
        $model->ip = Yii::$app->request->getUserIP();

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
        $model->ip = Yii::$app->request->getUserIP();
        if (!empty($allParameters)) {
            $model->all_parameters = $allParameters;
            $model->save();
        }
        return Json::encode(['success' => $data]);
    }

    /**
     * 替换广告组的参数，目前只有 click_id 和ch_id
     * @param Campaign $camp
     * @param $click_uuid
     * @param $ch_id
     * @return string
     */
    private function genAdvLink($camp, $click_uuid, $ch_id)
    {
        $paras = array(
            'click_id' => $click_uuid,
            'ch_id' => $ch_id,
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
            $link .= $post_param;
        } else {
            $link .= 'click_id=' . $click_uuid; //默认
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

        //2.ip 限制
        $Info = \Yii::createObject([
            'class' => '\rmrevin\yii\geoip\HostInfo',
            'host' => '116.66.221.210', // some host or ip
        ]);
        $geo = $Info->getCountryCode();   // US
        $target = $campaign->target_geo;
        if (strpos($target, $geo) === false) {
            return 501;
        }

        //3.单子状态
        //4.单子时间
        //正常0
        $link = $this->genAdvLink($campaign, $model->click_uuid, $model->ch_id);
        $model->redirect = $link;
        $model->save();
        return 200;
    }

    private function restrictionFeed()
    {
        //2.ip 限制
    }

    private function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Missing parameters',
            500 => 'Can`t found the campaign',
            501 => 'Your country is not allow!',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}
