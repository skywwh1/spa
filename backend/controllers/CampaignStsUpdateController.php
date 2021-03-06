<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\CampaignCreativeLink;
use common\models\CampaignSearch;
use common\models\CampaignSubChannelLog;
use common\models\CampaignUpdate;
use common\models\Deliver;
use common\utility\MailUtil;
use Yii;
use common\models\CampaignStsUpdate;
use common\models\CampaignStsUpdateSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\base\Model;

/**
 * CampaignStsUpdateController implements the CRUD actions for CampaignStsUpdate model.
 */
class CampaignStsUpdateController extends Controller
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
                        'actions' => [
                            'pause',
                            'update-cap',
                            'update-discount',
                            'update-payout',
                            'update-geo',
                            'index',
                            'update-creative',
                            'sub-pause',
                            'sts-restart',
                            'update-price'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CampaignStsUpdate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CampaignStsUpdateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $data = $dataProvider->getModels();
//        foreach($data as $item){
//            $item->create_time =  $item->create_time+28800;
//            $item->effect_time =  $item->effect_time+28800;
//        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CampaignStsUpdate model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CampaignStsUpdate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CampaignStsUpdate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CampaignStsUpdate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CampaignStsUpdate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CampaignStsUpdate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CampaignStsUpdate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CampaignStsUpdate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param integer $type //1 campaign 2. sts
     * @return mixed
     */
    public function actionPause($campaign_id, $channel_id, $type)
    {
        $this->layout = false;
        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        $model->channel_id = $channel_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->type = $type;//2 is sts 1 is campaign
            $model->name = 'pause';
            $model->effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
            $model->save();
            if ($type == 2) {
                $sts = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id]);
                $sts->end_time = $model->effect_time;
                $sts->save();
//                return $this->redirect(Yii::$app->request->referrer);
                $this->asJson('success!');
            } else if ($type == 1) {
                $camp = Campaign::findById($model->campaign_id);
                $camp->promote_end = $model->effect_time;
                $camp->save();

                CampaignUpdate::updateLog($campaign_id,$model->name,$model->effect_time,$model->value);
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            if ($type == 2) {
                $searchModel = new CampaignStsUpdateSearch();
                $searchModel->name = 'pause';
                $searchModel->type = $type;
                $searchModel->campaign_id = $campaign_id;
                $searchModel->channel_id = $channel_id;
                $dataProvider = $searchModel->campaignUpdateSearch();//获取campaign更新者的信息
            } else if ($type == 1) {
                $searchModel = new CampaignSearch();
                $action =  'pause';
                $dataProvider= $searchModel->updateSearch($campaign_id,$action);
            }

            return $this->renderAjax('pause', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }

    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param integer $type //1 campaign 2. sts
     * @return mixed
     */
    public function actionUpdateCap($campaign_id, $channel_id, $type)
    {

        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        $model->channel_id = $channel_id;
        if ($type == 2) {
            $sts = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id]);
            $model->old_value = $sts->daily_cap;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($type == 2) {
                $model->type = $type;//2 is sts 1 is campaign
                $model->effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
                $model->save();
             // return $this->redirect(['deliver/index']);
//                return $this->redirect(Yii::$app->request->referrer);
                $this->asJson('success!');
            }
        } else {
            $searchModel = new CampaignStsUpdateSearch();
            $searchModel->name = 'cap';
            $searchModel->type = $type;
            $searchModel->campaign_id = $campaign_id;
            $searchModel->channel_id = $channel_id;
            $dataProvider = $searchModel->campaignUpdateSearch();
            return $this->renderAjax('update_cap', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }

    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $type
     * @return string|\yii\web\Response
     */
    public function actionUpdateDiscount($campaign_id, $channel_id, $type)
    {

        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        $model->channel_id = $channel_id;
        $sts = new Deliver();
        if ($type == 2) {
            $sts = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id]);
            $model->old_value = $sts->discount;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($type == 2) {
                $model->type = $type;//2 is sts 1 is campaign
                $model->effect_time = time();
                $model->is_send = 1; // 不发
                $model->save();

                $sts->discount = (int)$model->value;
                //修改扣量基数
                $sts->discount_numerator = 1;
                $sts->discount_denominator = 1;
                $sts->save();
            //    return $this->redirect(['deliver/index']);
//                return $this->redirect(Yii::$app->request->referrer);
                $this->asJson('success!');
            }
        } else {
            $searchModel = new CampaignStsUpdateSearch();
            $searchModel->name = 'discount';
            $searchModel->type = $type;
            $searchModel->campaign_id = $campaign_id;
            $searchModel->channel_id = $channel_id;
            $dataProvider = $searchModel->campaignUpdateSearch();//获取campaign更新者的信息
            return $this->renderAjax('update_discount', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }

    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $type
     * @return string|\yii\web\Response
     */
    public function actionUpdatePayout($campaign_id, $channel_id, $type)
    {

        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        $model->channel_id = $channel_id;
        $sts = new Deliver();
        if ($type == 2) {
            $sts = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id]);
            $model->old_value = $sts->pay_out;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($type == 2) {
                $model->type = $type;//2 is sts 1 is campaign
//                $model->is_send = 1; // 不发
                $model->effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
                $model->save();

             //   return $this->redirect(['deliver/index']);
//                return $this->redirect(Yii::$app->request->referrer);
                $this->asJson('success!');
            }

        } else {
            $searchModel = new CampaignStsUpdateSearch();
            $searchModel->name = 'payout';
            $searchModel->type = $type;
            $searchModel->campaign_id = $campaign_id;
            $searchModel->channel_id = $channel_id;
            $dataProvider = $searchModel->campaignUpdateSearch();
            return $this->renderAjax('update_payout', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }

    }

    public function actionValidate()
    {
        $model = new CampaignStsUpdate();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $type
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionUpdateGeo($type,$channel_id,$campaign_id)
    {
        $this->layout = false;
        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        $model->channel_id = $channel_id;

        if ($model->load(Yii::$app->request->post())) {
            $camp = Campaign::findById($model->campaign_id);

            $model->type = $type;//2 is sts 1 is campaign
            $model->name = 'update-geo';
            $model->value =empty($model->target_geo) ? null:implode(',',$model->target_geo);
            $model->old_value = $camp->target_geo;
            $model->effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
            $model->save();

//            $camp->promote_end = $model->effect_time;
//            $camp->target_geo = empty($model->target_geo) ? null:implode(',',$model->target_geo);
            $camp->save();

            CampaignUpdate::updateLog($campaign_id,$model->name,$model->effect_time,$model->value);
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $searchModel = new CampaignSearch();
            $action =  'update-geo';
            $dataProvider= $searchModel->updateSearch($campaign_id,$action);
            return $this->renderAjax('update_geo', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $type
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionUpdateCreative($type,$channel_id,$campaign_id)
    {
        $this->layout = false;
        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        //1、获取campaign对应的CampaignCreativeLink，并将类型和链接放到数组里面
        $modelsLinkOld = CampaignCreativeLink::getCampaignCreativeLinksById($campaign_id);
        $old_creative_links = array();
        foreach ($modelsLinkOld as $modelLink) {
            $old_creative_links[]=$modelLink['creative_link'];
            $creative_type = CampaignCreativeLink::getCreativeLinkValue($modelLink['creative_type']);
            array_push($old_creative_links,$creative_type.':'.$modelLink['creative_link']);
        }

        if ($model->load(Yii::$app->request->post())) {
            $camp = Campaign::findById($model->campaign_id);

            //2、获取页面新填入的CampaignCreativeLink，并将类型和链接放到数组里面
            $modelsLink = Yii::$app->request->post('CampaignCreativeLink');// return 2
            //3、将新，旧的链接和类型存到CampaignStsUpdate里面
            $model->type = $type;//2 is sts 1 is campaign
            $model->name = 'update-creative';
            $model->channel_id = $channel_id;
//            $model->value = $model->creative_link;
//            $model->old_value = $camp->creative_link;
            $model->value = json_encode($modelsLink);
            $model->old_value = empty($old_creative_links)?null:implode(";",$old_creative_links);

            $model->effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
            $model->save();

//            $camp->promote_end = $model->effect_time;
//            $camp->creative_link = $model->creative_link;
            $camp->save();
            CampaignUpdate::updateLog($campaign_id,$model->name,$model->effect_time,$model->value);
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $searchModel = new CampaignSearch();
            $action =  'update-creative';
            $dataProvider= $searchModel->updateSearch($campaign_id,$action,$model->effect_time);
            return $this->renderAjax('update_creative', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'modelsLink' => (empty($modelsLinkOld)) ? [new CampaignCreativeLink] : $modelsLinkOld
            ]);
        }
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @return string|\yii\web\Response
     */
    public function actionSubPause($campaign_id, $channel_id)
    {
        $this->layout = false;
        $model = new CampaignSubChannelLog();
        $model->campaign_id = $campaign_id;
        $model->channel_id = $channel_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->name = 'sub-pause';
            $model->creator = Yii::$app->user->id;
            $model->is_effected = 0;//默认不生效
            $model->effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
            $model->save();

            if ($model->is_send == 1){
                MailUtil::pauseSubChannel($model);
            }
            $this->asJson('success!');
//            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('sub_pause', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param integer $type //1 campaign 2. sts
     * @return mixed
     */
    public function actionStsRestart($campaign_id, $channel_id, $type)
    {
        $this->layout = false;
        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        $model->channel_id = $channel_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->type = $type;//2 is sts 1 is campaign
            $model->name = 'sts-restart';
            $model->effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
            $model->save();

            // return $this->redirect(['deliver/index']);
//            return $this->redirect(Yii::$app->request->referrer);
            $this->asJson('success!');
        } else {
            return $this->renderAjax('sts-restart', [
                'model' => $model,
            ]);
        }

    }

    /**
     * @param $campaign_id
     * @return string|\yii\web\Response
     */
    public function actionUpdatePrice($campaign_id)
    {
        $this->layout = false;
        $model = new CampaignStsUpdate();
        $model->campaign_id = $campaign_id;
        $camp = Campaign::findById($model->campaign_id);
        $model->pay_out_old = $camp->now_payout;
        $model->adv_price_old = $camp->adv_price;

        if ($model->load(Yii::$app->request->post())) {
            $effect_time = empty($model->effect_time) ? null : strtotime($model->effect_time);
            $pay_out = $model->adv_price;
            $model->type = 1;//2 is sts 1 is campaign
            $model->name = 'update-price';
            $model->value = $model->adv_price;
            $model->old_value = $camp->adv_price;
            $model->is_send = 0;
            $model->effect_time = $effect_time;
            $model->save();
            CampaignUpdate::updateLog($campaign_id,$model->name,$model->effect_time,$model->adv_price);

            $model2 = new CampaignStsUpdate();
            $model2->campaign_id = $campaign_id;
            $model2->type = 1;//2 is sts 1 is campaign
            $model2->name = 'update-payout';
            $model2->value = $pay_out;
            $model2->old_value = $camp->now_payout;
            $model2->is_send = 0;
            $model2->effect_time = $effect_time;
            $model2->save();
            CampaignUpdate::updateLog($campaign_id,$model2->name,$model->effect_time,$model->pay_out);

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $searchModel = new CampaignSearch();
            $arr_act =['update-price','update-payout'];
            $dataProvider= $searchModel->updateSearch($campaign_id,$arr_act);
            return $this->renderAjax('update_price', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
}
