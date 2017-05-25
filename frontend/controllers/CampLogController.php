<?php

namespace frontend\controllers;

use common\models\ApplyCampaign;
use common\models\Campaign;
use common\models\Deliver;
use frontend\models\AllCampaignSearch;
use frontend\models\CampaignChannelLog;
use frontend\models\CampaignChannelLogSearch;
use frontend\models\MyCampaignSearch;
use common\models\CampaignCreativeLink;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CampLogController implements the CRUD actions for CampaignChannelLog model.
 */
class CampLogController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = "my_main";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',
                            'alloffers',
                            'myoffers',
                            'view',
                            'campaign-view',
                            'apply',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CampaignChannelLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CampaignChannelLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all CampaignChannelLog models.
     * @return mixed
     */
    public function actionMyoffers()
    {
        $searchModel = new CampaignChannelLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('myoffers', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAlloffers()
    {
        $searchModel = new AllCampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('all_offers', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($campaign_id, $channel_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($campaign_id, $channel_id),
        ]);
    }

    /**
     * Finds the Deliver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return CampaignChannelLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $channel_id)
    {
        if (($model = CampaignChannelLog::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id])) !== null) {
            $modelCreativeLink = CampaignCreativeLink::getCampaignCreativeLinksById($campaign_id);
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



    public function actionCampaignView($id)
    {
//        if (($model = Campaign::findOne($id)) == null) {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//        return $this->renderAjax('campaign_view', [
//            'model' => $model,
//        ]);
        return $this->renderAjax('campaign_view', [
            'model' => $this->findMutipleModel($id),
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

    public function actionApply($id)
    {
        if (Yii::$app->request->isAjax) {
            $channel_id = Yii::$app->user->id;
            $campaign_id = $id;
            $apply = ApplyCampaign::findIdentify($campaign_id,$channel_id);
            if(empty($apply)){
                $model = new ApplyCampaign();
                $model->channel_id = $channel_id;
                $model->campaign_id = $campaign_id;
                $model->status = 1;
                $model->save();
            }
            $searchModel = new AllCampaignSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//            return $this->render('all_offers', [
//                'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//            ]);
            return $this->redirect(Yii::$app->request->referrer);
        }
        return null;
    }
}
