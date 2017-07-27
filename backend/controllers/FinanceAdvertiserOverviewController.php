<?php

namespace backend\controllers;

use backend\models\FinanceAdvertiserBillTermSearch;
use Yii;

class FinanceAdvertiserOverviewController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new FinanceAdvertiserBillTermSearch();
        $dataProvider = $searchModel->overviewSearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
