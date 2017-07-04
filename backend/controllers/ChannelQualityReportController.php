<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\Channel;
use common\models\LogAutoCheckSub;
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
                            'quality',
                            'update',
                            'delete',
                            'columns',
                            'email',
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
     * Lists all ChannelQualityReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelQualityReportSearch();
        $searchModel->read_only = false;
        $searchModel->time_zone = 'Etc/GMT-8';

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');
//        var_dump($searchModel->type);
//        die();
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

        $cols = [];
        $dynamic_cols = [];
//        var_dump(count($columns));
//        var_dump(count($models));
//        die();
        if (!empty($models) && !(empty($columns)) ){
            foreach($models as $model){
                foreach ($columns as $column){
                    if ($model['campaign_id'] == $column->campaign_id
                        && $model['channel_id'] == $column->channel_id
                        && $model['sub_channel'] == $column->sub_channel
                        && $model['timestamp'] == $column->time) {
                        $model['column_name'][$column->name] = $column->value;
                        $cols[$column->name] = $column->value;
//                        $model['column_name']['campaign_id'] = $column->campaign_id;
//                        $model['column_name']['channel_id'] = $column->channel_id;
//                        $model['column_name']['sub_channel'] = $column->sub_channel;
//                        $model['column_name']['timestamp'] = $column->time;
                    }
                }
                if (!empty($model['column_name'])){
                    $dynamic_cols[] = $model['column_name'];
                }
            }
        }
//        var_dump($dynamic_cols);
//        die();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columnName' => $dynamic_cols,
            'cols' => $cols,
        ]);
    }

    public function actionQuality($campaign,$channel,$timeZone)
    {
        $searchModel = new ChannelQualityReportSearch();
        $searchModel->campaign_id = $campaign;
        $searchModel->channel_id = $channel;
        $searchModel->time_zone = $timeZone;
        $searchModel->read_only = true;

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider_column = $searchModel->dynamicSearch(Yii::$app->request->queryParams);

        $models = empty($dataProvider)?null:$dataProvider->getModels();
        $columns = empty($dataProvider_column)?null:$dataProvider_column->getModels();

        $cols = [];
        $dynamic_cols = [];
        if (!empty($models) && !(empty($columns))){
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columnName' => $dynamic_cols,
            'cols' => $cols,
        ]);
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $sub_channel
     * @param $time
     * @param $name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($campaign_id, $channel_id, $sub_channel, $time,$name)
    {
//        $model = $this->findModel($campaign_id, $channel_id, $sub_channel, $time);
//        var_dump($campaign_id, $channel_id, $sub_channel, $time,$name);
//        die();

        $model = QualityDynamicColumn::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'sub_channel' => $sub_channel, 'time' => $time,'name' => $name]);

        if (Yii::$app->request->post('hasEditable') == 0) {
            $out = Json::encode([ 'message' => '']);
            if (empty($model)){
                $model = new QualityDynamicColumn();
                $model->campaign_id = $campaign_id;
                $model->channel_id = $channel_id;
                $model->sub_channel = $sub_channel;
                $model->time = $time;
                $model->name = $name;
            }
//            $model->value = $_POST[str_replace(' ', '_', $name)];
            $model->value = $name;
            $model->save();

            $out = Json::encode(['message' => 'successifully saved']);
            echo $out;
            return;
        }

    }

    /**
     * Deletes an existing ChannelQualityReport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param string $sub_channel
     * @param integer $time
     * @return mixed
     */
    public function actionDelete($campaign_id, $channel_id, $sub_channel, $time)
    {
        $this->findModel($campaign_id, $channel_id, $sub_channel, $time)->delete();

        return $this->redirect(['index']);
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

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $start
     * @param $end
     * @param $type
     * @return string|\yii\web\Response
     */
    //创建的时候增加camp
    public function actionColumns($campaign_id,$channel_id,$start,$end,$type)
    {
        $model = new QualityDynamicColumn();
        $model->channel_id = $channel_id;
        $model->campaign_id = $campaign_id;

        //点击新增的时候，出现多个campaign，channel
        if ($model->load(Yii::$app->request->post())) {

            //查询sub_channel_hourly表获取所选时间和campaign,channel的数据以便和动态列表数据一一对应
            $searchModel = new ChannelQualityReportSearch();
            $searchModel->campaign_id = $campaign_id;
            $searchModel->channel_id = $channel_id;
            $searchModel->start = $start;
            $searchModel->end = $end;
            $searchModel->time_zone = 'Etc/GMT-8';

            switch($type){
                case 1:
                    $dataProvider = $searchModel->weekSearch(Yii::$app->request->queryParams);
                    break;
                case 2:
                    $dataProvider = $searchModel->monthSearch(Yii::$app->request->queryParams);
                    break;
                default:
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    break;
            }

            $models = empty($dataProvider)?null:$dataProvider->getModels();
            if (!empty($models)){
                foreach($models as $static){
                    $quality = QualityDynamicColumn::findOne(['campaign_id' => $static['campaign_id'], 'channel_id' => $static['channel_id'], 'sub_channel' => $static['sub_channel'], 'time' =>  $static['timestamp'],'name' =>  $model->name]);

                    if (empty($quality)){
                        $quality = new QualityDynamicColumn();
                    }
                    $quality->campaign_id = $static['campaign_id'];
                    $quality->channel_id = $static['channel_id'];
                    $quality->sub_channel = $static['sub_channel'];
                    $quality->time = $static['timestamp'];
                    $quality->name = $model->name;
                    $quality->save();
                }
            }

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('columns', [
                'model' => $model,
            ]);
        }
    }

    public function actionEmail($campaign_id,$channel_id,$start,$end,$type){
        $searchModel = new ChannelQualityReportSearch();
        $searchModel->time_zone = 'Etc/GMT-8';
        $searchModel->campaign_id = $campaign_id;
        $searchModel->channel_id = $channel_id;
        $searchModel->start = $start;
        $searchModel->end = $end;

        switch($type){
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

        $cols = [];
        $dynamic_cols = [];
        if (!empty($models) && !(empty($columns))){
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
        $channel = Channel::findOne(['id' => $channel_id ]);
        $campaign = Campaign::findOne(['id' => $campaign_id ]);
        $date_range = $start.'~'.$end;

        if(MailUtil::sendQualityOffers($channel,$campaign,$models,$dynamic_cols,$cols,$date_range)){
            $this->actionNotice($campaign_id,$channel_id);//发送邮件成功则提醒渠道看质量报告
            $this->asJson("send email success!");
        }else{
            $this->asJson("send email fail!");
        }
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     */
    private function actionNotice($campaign_id,$channel_id){
        $campaign = Campaign::findOne(['id' => $campaign_id ]);
        $channel = Channel::findOne($channel_id);
        $auto_check = new QualityAutoCheck();
        $auto_check->campaign_id = $campaign_id;
        $auto_check->campaign_name = $campaign->campaign_name;
        $auto_check->channel_id = $channel_id;
        $auto_check->channel_name = $channel->username;
        $auto_check->is_send = 0;
        $auto_check->save();
    }
}
