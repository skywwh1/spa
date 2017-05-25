<?php

namespace backend\controllers;

use common\models\Advertiser;
use common\models\Category;
use common\models\Mycart;
use common\models\ChannelSearch;
use common\models\CampaignCreativeLink;
use Yii;
use common\models\Campaign;
use common\models\CampaignSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;


/**
 * CampaignController implements the CRUD actions for Campaign model.
 */
class CampaignController extends Controller
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
                            'view',
                            'index',
                            'create',
                            'update',
                            'delete',
                            'campaigns_by_uuid',
                            'get_adv_list',
                            'get_geo',
                            'get_category',
                            'get_campaign_uuid_multiple',
                            'restart',
                            'api-index',
                            'cpa-index',
                            'mundo-index',
                            'recommend',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'get_category',
                        ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $this->layout='mylayout';
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionApiIndex()
    {
//        $this->layout='mylayout';
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->apiSearch(Yii::$app->request->queryParams);

        return $this->render('api_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionMundoIndex()
    {
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->mundoSearch(Yii::$app->request->queryParams);

        return $this->render('mundo_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionCpaIndex()
    {
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->cpaSearch(Yii::$app->request->queryParams);

        return $this->render('cpa_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Campaign model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
//        return $this->renderAjax('view', [
//            'model' => $this->findModel($id),
//        ]);
        return $this->renderAjax('view', [
            'model' => $this->findMutipleModel($id),
        ]);
    }

    /**
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        $model = new Campaign();
//        $this->beforeUpdate($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $this->beforeSave($model);
//            $model->status = 1; //running
//            if ($model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        }
//        return $this->render('create', [
//            'model' => $model,
//        ]);
        $model = new Campaign();
        $modelsLink = array();
        $this->beforeUpdate($model);

        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            Model::loadMultiple($modelsLink, Yii::$app->request->post());
            $this->beforeSave($model);

            $model->status = 1; //running

            $modelsLink = Yii::$app->request->post('CampaignCreativeLink');// return 2

            if ($flag = $model->save(false)) {
                foreach ($modelsLink as $modelLink) {
                    if(empty($modelLink) || empty( $modelLink['creative_link'])){
                        continue;
                    }
                    $ccl = new CampaignCreativeLink();
                    $ccl->campaign_id = $model->id;
                    $ccl->creative_link = $modelLink['creative_link'];
                    $ccl->creative_type = $modelLink['creative_type'];
                    if (! ($flag = $ccl->save(false))) {
                        break;
                    }
                }
            }
            if ($flag) {
                return $this->render('view', [
                    'model' => $this->findMutipleModel($model->id),
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelsLink' => (empty($modelsLink)) ? [new CampaignCreativeLink] : $modelsLink
        ]);

    }

    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsLink = CampaignCreativeLink::getCampaignCreativeLinksById($id);

        $this->beforeUpdate($model);
        if ($model->load(Yii::$app->request->post())) {
            $this->beforeSave($model);

            $model->status = 1; //running

            $oldHouseIDs = ArrayHelper::map($modelsLink, 'id', 'id');
            $modelsLink = Yii::$app->request->post('CampaignCreativeLink');// return 2
            $deletedHouseIDs = array_diff($oldHouseIDs, array_filter(ArrayHelper::map($modelsLink, 'id', 'id')));

            if ($flag = $model->save(false)) {
                if (! empty($deletedHouseIDs)) {
                    CampaignCreativeLink::deleteAll(['id' => $deletedHouseIDs]);
                }

                foreach ($modelsLink as $modelLink) {

                    if (!empty($modelLink)&&isset($modelLink['id'])){
                        $ccl = CampaignCreativeLink::findOne($modelLink['id']);
                    }

                    if (!empty($ccl)){
                        $ccl->creative_link = $modelLink['creative_link'];
                        $ccl->creative_type = $modelLink['creative_type'];
                    }else{
                        if(empty( $modelLink['creative_link'])){
                            continue;
                        }
                        $ccl = new CampaignCreativeLink();
                        $ccl->campaign_id = $model->id;
                        $ccl->creative_link = $modelLink['creative_link'];
                        $ccl->creative_type = $modelLink['creative_type'];
                    }

                    if (! ($flag = $ccl->save(false))) {
                        break;
                    }
                }
            }
            if ($flag) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->renderAjax('update', [
            'model' => $model,
            'modelsLink' => (empty($modelsLink)) ? [new CampaignCreativeLink] : $modelsLink
        ]);
    }

    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRestart($id)
    {
        $this->layout = false;
        $model = $this->findModel($id);
        $model->promote_end = null;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            $model->status = 1;
//            if ($model->promote_end != 0) {
//                $model->promote_end = strtotime($model->promote_end);
//            } else {
//            }
            $model->promote_end = null;
            if ($model->save()) {
                return 'success';
            } else {
                return 'fail';
            }
        } else {
            return $this->renderAjax('restart', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Campaign model.
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
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCampaigns_by_uuid($uuid)
    {
        echo Campaign::getCampaignsByUuid($uuid);
    }

    public function actionGet_adv_list($name)
    {
        return \JsonUtil::toTypeHeadJson(Advertiser::getAdvNameListByName($name));
    }

    public function actionGet_geo($name)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!$name) {
            return $out;
        }

        $data = RegionsDomain::find()
            ->select('domain id, domain text')
            ->andFilterWhere(['like', 'domain', $name])
            ->limit(50)
            ->asArray()
            ->all();

        $out['results'] = array_values($data);

        return $out;
//        return \JsonUtil::toTypeHeadJson(RegionsDomain::getGeoListByName($name));
    }

    public function actionGet_category($q = null, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('category')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Category::findOne($id)->name];
        }
        return $out;
    }

    public function actionGet_campaign_uuid_multiple($uuid)
    {
        return Campaign::getCampaignsByUuidMultiple($uuid);
    }

    /**
     * @param Campaign $campaign
     */
    protected function beforeUpdate(&$campaign)
    {
        if (!empty($campaign->target_geo)) {
            $campaign->target_geo = explode(',', $campaign->target_geo);
        }
        if (!empty($campaign->traffic_source)) {
            $campaign->traffic_source = explode(',', $campaign->traffic_source);
        }
        if (!empty($campaign->device)) {
            $campaign->device = explode(',', $campaign->device);
        } else {
            $campaign->device = ['phone', 'tablet'];
        }
        if (empty($campaign->min_version)) {
            $campaign->min_version = 'min';
        }
        if (empty($campaign->max_version)) {
            $campaign->max_version = 'max';
        }
    }

    /**
     * @param Campaign $model
     */
    protected function beforeSave(&$model)
    {
        $advertiser = Advertiser::getOneByUsername($model->advertiser);
        $model->advertiser = isset($advertiser) ? $advertiser->id : null;
        if (!empty($model->promote_start)) {
            $model->promote_start = strtotime($model->promote_start);
        }
        if (!empty($model->promote_end)) {
            $model->promote_end = strtotime($model->promote_end);
        }
        if (!empty($model->target_geo)) {
            $model->target_geo = implode(',', $model->target_geo);
        }
        if (!empty($model->traffic_source)) {
            $model->traffic_source = implode(',', $model->traffic_source);
        }
        if (!empty($model->device)) {
            $model->device = implode(',', $model->device);
        }
    }

    public function actionRecommend($id)
    {
        $cam = $this->findModel($id);

        $searchModel = new ChannelSearch();
        $searchModel->os = $cam->platform;
        $searchModel->strong_geo = $cam->target_geo;
        $searchModel->strong_category = $cam->category;
        $dataProvider = $searchModel->recommendSearch(Yii::$app->request->queryParams);

        return $this->render('recommend_channel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'campaign' => $cam,
        ]);
    }

    /**
     * Finds the Campaign model,CampaignCreativeLink based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findMutipleModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            $modelCreativeLink = CampaignCreativeLink::getCampaignCreativeLinksById($id);
            $creativeLinks = array();

            foreach ($modelCreativeLink as $modelLink) {
                $modelLink->creative_type = CampaignCreativeLink::getCreativeLinkValue($modelLink->creative_type);
                if(!empty($modelLink->creative_type) && !empty($modelLink->creative_link)){
                    array_push($creativeLinks,$modelLink->creative_type.":" .$modelLink->creative_link);
                }
            }

            $model->creative_link = implode(";",$creativeLinks);;
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
