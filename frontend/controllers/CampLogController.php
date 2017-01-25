<?php

namespace frontend\controllers;

use frontend\models\AllCampaignSearch;
use frontend\models\CampaignChannelLogSearch;
use frontend\models\MyCampaignSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
                        'actions' => ['index', 'alloffers', 'myoffers'],
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


}
