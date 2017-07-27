<?php

namespace backend\controllers;

use backend\models\FinanceAdvertiserBillTerm;
use backend\models\FinanceAdvertiserCampaignBillTerm;
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
                        'actions' => ['index','edit'],
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
        $dataProvider = $searchModel->overviewSearch(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
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
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
