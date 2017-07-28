<?php

namespace backend\controllers;

use backend\models\FinanceAdvertiserBillTerm;
use backend\models\FinanceAdvertiserCampaignBillTerm;
use backend\models\FinanceChannelBillTerm;
use backend\models\FinanceChannelBillTermSearch;
use backend\models\FinanceChannelCampaignBillTerm;
use common\models\Campaign;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class FinanceChannelOverviewController extends \yii\web\Controller
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
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FinanceChannelBillTermSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->overviewSearch(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        if (!empty($models)){
            foreach ($models as $item) {
                $campaign_ids = $item->campaigns;
                $advs = [];
                foreach ($campaign_ids as $camp) {
                    $adv = $camp->advertiser;
                    $advs[] = $adv;
                }
                $advs = array_unique($advs);
                $receivable = FinanceAdvertiserCampaignBillTerm::getReceivedOrReceivablePerMonthByAdv($item->period, 6, $item->channel_id, $advs);
                $received = FinanceAdvertiserCampaignBillTerm::getReceivedOrReceivablePerMonthByAdv($item->period,7, $item->channel_id, $advs);
                $item->adv_receivable = $receivable->revenue;
                $item->adv_received = $received->revenue;
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $bill_id
     * @param $adv_received
     * @param $adv_receivable
     * @return string
     */
    public function actionView($bill_id,$adv_received,$adv_receivable){
        $model = FinanceChannelBillTerm::findOne(['bill_id' => $bill_id]);
        $model->adv_received = $adv_received;
        $model->adv_receivable = $adv_receivable;
        $model->cash_flow = $model->adv_received-$model->final_cost;
        return $this->renderAjax('view',
            [
                'model' => $model,
            ]);
    }
}
