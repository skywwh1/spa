<?php
namespace console\controllers;

use backend\models\FinanceAdvertiserBillTerm;
use common\models\Campaign;
use common\models\Advertiser;
use common\utility\MailUtil;
use yii\console\Controller;

/**
 * Class AdvertiserController
 * @package console\controllers
 */
class AdvertiserController extends Controller
{

    /**
     * 每月1号发送一封对账邀请邮件给到广告主，每月10号再次发送邀请，14号再次发送邀请。若Advertiser 账单为已提交状态的，则这个广告主不用发送。
     */
    public function actionReconciliationInvitation()
    {
        $models = FinanceAdvertiserBillTerm::getNumberConfirmSendMail();
        if (isset($models)) {
            foreach ( $models as $financeAdv){
//                var_dump($financeAdv->adv_id);
                $advertiser = Advertiser::findOne($financeAdv->adv_id);
                if(!empty($advertiser)){
                    $this->echoMessage('Number Confirm');
                    if (MailUtil::numberConfirm($advertiser)) {
                        $this->echoMessage($advertiser->username . ' send success');
                    } else {
                        $this->echoMessage($advertiser->username . ' send fail');
                    }
                    $this->echoMessage("waiting 1s");
                    sleep(1);
                }
            }
        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }

}