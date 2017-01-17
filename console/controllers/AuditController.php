<?php
namespace console\controllers;

use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use common\models\Stream;
use linslin\yii2\curl\Curl;
use yii\console\Controller;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: wh wu
 * Date: 1/15/2017
 * Time: 3:39 PM
 */
class AuditController extends Controller
{

    public function actionIndex()
    {
        echo "sdfadsf \n";
    }

    public function actionCount_feed()
    {
        $needCounts = Feed::findNeedCounts();
        //更新campaign的真实安装量。
        $this->updateMatchInstall($needCounts);
        // 查出所有的没标记的post back。
//        foreach ($needCounts as $k) {
//            $stream = Stream::findOne(['click_uuid' => $k->click_id]);
//            $campaign_uuid = $stream->cp_uid;
//            $channel_id = $stream->ch_id;
//            if (Stream::isFirstPost($campaign_uuid, $channel_id)) {
//                //TODO link
//                $stream->post_status = 1;
//            }
//        }

// 1查出所有feed

// 查出点击记录 对应的post back。

// 每15分钟，每>10条记录
    }

// 每20分钟post
    public function actionPost_back()
    {
        $curl = new Curl();
        $needPosts = Stream::getNeedPosts();
        foreach ($needPosts as $k) {
            $response = $curl->get($k->post_link);
            $k->post_status = 3;
            $k->post_time = time();
            $k->save();
            echo " \n";
            echo "Post to " . $k->post_link . " \n";
            echo "waiting 5 seconds \n";
            echo "Time: " . time() . " \n";
            sleep(5);
        }
    }

    /**
     * @param array|\yii\db\ActiveRecord[] $needCounts
     */
    protected function updateMatchInstall($needCounts)
    {
//        $needCounts = Feed::findNeedCounts();
//        var_dump(count($needCounts));
//        die();
        $data = array();
        foreach ($needCounts as $k) {
            $stream = Stream::findOne(['click_uuid' => $k->click_id]);
            if ($stream == null)
                continue;
            $campaign_uuid = $stream->cp_uid;
            $campaign_id = Campaign::findByUuid($campaign_uuid)->id;
            $channel_id = $stream->ch_id;
            if (isset($data[$campaign_id . ',' . $channel_id])) {
                $data[$campaign_id . ',' . $channel_id] += 1;
            } else {
                $data[$campaign_id . ',' . $channel_id] = 1;
            }
        }
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $camp_chanl = explode(',', $k);
                $deliver = Deliver::findIdentity($camp_chanl[0], $camp_chanl[1]);
                $deliver->match_install = $v;
                $deliver->campaign_uuid='sdsd';
                $deliver->channel0='ss';
                $deliver->save();
                var_dump($deliver->getErrors());
                die();
            }
        }
    }
}