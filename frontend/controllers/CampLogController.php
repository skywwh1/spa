<?php

namespace frontend\controllers;

use frontend\models\AllCampaignSearch;
use frontend\models\CampaignChannelLog;
use frontend\models\CampaignChannelLogSearch;
use frontend\models\MyCampaignSearch;
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
                        'actions' => ['index', 'alloffers', 'myoffers','view'],
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
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
