<?php

namespace backend\controllers;

use backend\models\FinanceAdvertiserBillTerm;
use backend\models\FinanceAdvertiserBillTermSearch;
use backend\models\FinanceChannelCampaignBillTerm;
use Yii;

class FinanceAdvertiserOverviewController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new FinanceAdvertiserBillTermSearch();
        $dataProvider = $searchModel->overviewSearch(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        if (!empty($models)){
            foreach ($models as $item) {
                $channels = $item->channels;
                $ch_ids = [];
                foreach ($channels as $cha) {
                    $id = $cha->id;
                    $ch_ids[] = $id;
                }
                $ch_ids = array_unique($ch_ids);

                $campaign_ids = $item->campaigns;
                $camps = [];
                foreach ($campaign_ids as $camp) {
                    $id = $camp->id;
                    $camps[] = $id;
                }
                $camps = array_unique($camps);
                $payable = FinanceChannelCampaignBillTerm::getPaidOrPayablePerMonthByCha($item->period, 6,$ch_ids,$camps);
                $paid = FinanceChannelCampaignBillTerm::getPaidOrPayablePerMonthByCha($item->period,7, $ch_ids,$camps);
                $item->cha_payable = $payable->cost;
                $item->cha_paid = $paid->cost;
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $bill_id
     * @param $cha_paid
     * @param $cha_payable
     * @return string
     */
    public function actionView($bill_id,$cha_paid,$cha_payable){
        $model = FinanceAdvertiserBillTerm::findOne(['bill_id' => $bill_id]);
        $model->cha_paid = $cha_paid;
        $model->cha_payable = $cha_payable;
        $model->cash_flow = $model->cha_paid-$model->cost;
        return $this->renderAjax('view',
            [
                'model' => $model,
            ]);
    }
}
