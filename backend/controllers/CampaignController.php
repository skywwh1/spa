<?php

namespace backend\controllers;

use common\models\Advertiser;
use common\models\Category;
use common\models\RegionsDomain;
use Yii;
use common\models\Campaign;
use common\models\CampaignSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

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
     * Displays a single Campaign model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Campaign();

        if ($model->load(Yii::$app->request->post())) {
            $this->beforeSave($model);
            $model->status = 1; //running
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
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
        $this->beforeUpdate($model);
        if ($model->load(Yii::$app->request->post())) {
            $this->beforeSave($model);
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
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
            if ($model->promote_end != 0) {
                $model->promote_end = strtotime($model->promote_end);
            } else {
                $model->promote_end = null;
            }
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
        $campaign->target_geo = explode(',', $campaign->target_geo);
        if (!empty($campaign->traffic_source)) {
            $campaign->traffic_source = explode(',', $campaign->traffic_source);
        }
        if (!empty($campaign->device)) {
            $campaign->device = explode(',', $campaign->device);
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
}
