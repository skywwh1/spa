<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use Yii;
use common\models\Stream;
use common\models\StreamSearch;
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
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }
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
                ],
            ],
        ];
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

        $message = "";
        if (!$model->validate() && $model->hasErrors()) {
            foreach ($model->getErrors() as $k => $v) {
                $message .= implode("", $v) . "</br>";
            }

        } else {

            $camp = Campaign::findByUuid($model->cp_uid);
            if (isset($camp)) {
                $deliver = Deliver::findIdentity($camp->id, $model->ch_id);
                if (isset($deliver)) {
                    $link = $this->genAdvLink($camp,$model->click_uuid,$model->ch_id);
                    $model->redirect = $link;
                    $model->save();
                    return $this->redirect($link);
                }
            }
        }
        return Json::encode(['success'=>$message]);
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
        return Json::encode(['success'=>$data]);
    }

    /**
     * 替换广告组的参数，目前只有 click_id 和ch_id
     * @param Campaign $camp
     * @param $click_uuid
     * @param $ch_id
     * @return string
     */
    private function genAdvLink($camp,$click_uuid,$ch_id){
        $paras = array(
            'click_id'=>$click_uuid,
            'ch_id'=>$ch_id,
        );

        $link = $camp->adv_link;
        if (strpos($link, '?') !== false) {
            $link .= '&';
        } else {
            $link .= '?';
        }
        $post_param = $camp->advertiser0->post_parameter;
        if (!empty($post_param)) {
            $post_param = str_replace('{click_id}',$paras['click_id'],$post_param);
            $post_param = str_replace('{ch_id}',$paras['ch_id'],$post_param);
            $link .= $post_param ;
        } else {
            $link .= 'click_id=' . $click_uuid;
        }

        return $link;
    }
}
