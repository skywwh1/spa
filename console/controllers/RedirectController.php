<?php
namespace console\controllers;
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017/6/24
 * Time: 9:41
 */

use yii\console\Controller;
use common\models\RedirectLog;

class RedirectController extends Controller
{

    /**
     * 开始时间和结束时间大于当前时间
     */
    public function actionRedirectStatus()
    {
        $models = RedirectLog::find()->where(['status' => 0,])
            ->andWhere(['<','start_time',time()])
            ->andWhere(['>','end_time',time()])
            ->all();
        if (isset($models)) {
            foreach ( $models as $item){
                $item->status = 1;
                $item->save();
            }
        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }

}