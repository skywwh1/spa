<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use common\models\Config;
use common\models\LogClick;
use common\models\LogClick2;
use common\models\LogEvent;
use common\models\LogEventHourly;
use yii\console\Controller;
use yii\db\Query;

/**
 * Class TestController
 * @package console\controllers
 */
class EventController extends Controller
{

    public function actionCount()
    {

        $start = Config::findLastEventHourly();
        $end = time();
        echo 'start event hourly ' . $start . "\n";
        echo 'end event hourly ' . $end . "\n";
        echo date('Y-m-d H:i:s', $end) . "\n";
        $this->statistic($start);

        Config::updateLastEventHourly($end);
    }

    private function statistic($start)
    {
        $events = LogEvent::findByTime($start);
        foreach ($events as $item) {
            $this->echoMessage('event: ' . $item->click_uuid);
            $logClick = LogClick::findByClickUuid($item->click_uuid);
            if (empty($logClick)) {
                $logClick = LogClick2::findByClickUuid($item->click_uuid);
            }
            if (!empty($logClick)) {
                $time_str = date('Y-m-d H:00', $item->create_time);
                $time = strtotime($time_str);
                $this->echoMessage('hourly ' . $time_str);
                $hourly = LogEventHourly::findOne(['campaign_id' => $logClick->campaign_id, 'channel_id' => $logClick->channel_id, 'time' => $time, 'event' => $item->event_name]);
                if (empty($hourly)) {
                    $hourly = new LogEventHourly();
                    $hourly->campaign_id = $logClick->campaign_id;
                    $hourly->channel_id = $logClick->channel_id;
                    $hourly->time = $time;
                    $hourly->event = $item->event_name;
                }
                $hourly->event_total += 1;
                if (!$hourly->save()) {
                    var_dump($hourly->errors);
                }

                $item->is_count = 1;
                $item->save();
            } else {
                $this->echoMessage('cannot found click_uuid ' . $item->click_uuid);
            }

        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }
}