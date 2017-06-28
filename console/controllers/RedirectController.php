<?php
namespace console\controllers;
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017/6/24
 * Time: 9:41
 */

use common\models\Deliver;
use yii\console\Controller;
use common\models\RedirectLog;

class RedirectController extends Controller
{

    /**
     * 开始时间和结束时间大于当前时间
     */
    public function actionRedirectStatus()
    {
        //将开始时间小于当前时间的数据导量，则
        $models = RedirectLog::find()->where(['status' => 0,])
            ->andWhere(['<','start_time',time()])
            ->andWhere(['or',['end_time' => 0],['>','end_time',time()]])
            ->all();
        if (isset($models)) {
            foreach ( $models as $item){
                $item->status = 1;
                $item->save();
                $sts = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                $sts->is_redirect = 1;
                $sts->save();
            }
        }

        $models = RedirectLog::find()->where(['status' => 1,])
            ->andWhere(['<','end_time',time()])
            ->all();
        if (isset($models)) {
            foreach ( $models as $item){
                $item->status = 2;
                $item->save();
                $sts = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                $sts->is_redirect = 0;
                $sts->save();
            }
        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }

}