<?php

namespace frontend\controllers;

use common\models\Campaign;
use common\models\Channel;
use common\models\QualityAutoCheck;
use common\models\QualityDynamicColumn;
use common\utility\MailUtil;
use Yii;
use DateTime;
use DateTimeZone;
use common\models\ChannelQualityReport;
use common\models\ChannelQualityReportSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChannelQualityReportController implements the CRUD actions for ChannelQualityReport model.
 */
class ChannelQualityReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',
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


    public function actionIndex()
    {
        $searchModel = new ChannelQualityReportSearch();
        $searchModel->channel_id = Yii::$app->user->id;
        $searchModel->read_only = false;
        $searchModel->time_zone = 'Etc/GMT-8';

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');

        $searchModel->load(Yii::$app->request->queryParams);
        switch($searchModel->type){
            case 1:
                $dataProvider = $searchModel->weekSearch(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->dynamicSearch(Yii::$app->request->queryParams);
                break;
            case 2:
                $dataProvider = $searchModel->monthSearch(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->dynamicSearch(Yii::$app->request->queryParams);
                break;
            default:
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->dynamicSearch(Yii::$app->request->queryParams);
                break;
        }


        $models = empty($dataProvider)?null:$dataProvider->getModels();
        $columns = empty($dataProvider_column)?null:$dataProvider_column->getModels();
//        var_dump($dataProvider_column->getModels());
//        die();
        $cols = [];
        $dynamic_cols = [];
        if (!empty($models) && !(empty($columns)) ){
            foreach($models as $model){
                foreach ($columns as $column){
                    if ($model['campaign_id'] == $column->campaign_id
                        && $model['channel_id'] == $column->channel_id
                        && $model['sub_channel'] == $column->sub_channel
                        && $model['timestamp'] == $column->time) {
                        $model['column_name'][$column->name] = $column->value;
                        $cols[$column->name] = $column->value;
                    }
                }
                if (!empty($model['column_name'])){
                    $dynamic_cols[] = $model['column_name'];
                }
            }
        }

        $this->read();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columnName' => $dynamic_cols,
            'cols' => $cols,
        ]);
    }

    /**
     * Finds the ChannelQualityReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param string $sub_channel
     * @param integer $time
     * @return ChannelQualityReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $channel_id, $sub_channel, $time)
    {
        if (($model = ChannelQualityReport::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'sub_channel' => $sub_channel, 'time' => $time])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function read(){
        $beginTheDayBefore=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $data = QualityAutoCheck::find()
            ->andFilterWhere(['>','create_time',$beginTheDayBefore])
            ->andFilterWhere(['channel_id' =>yii::$app->user->id])
            ->andFilterWhere(['is_send' =>0])
            ->all();
        foreach ($data as $item){
            $item->is_send = 1;
            $item->save();
        }
    }

}
