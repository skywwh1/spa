<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\SbAppAsset;
use yii\helpers\Html;
use common\models\CampaignStsUpdate;
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

SbAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Super ADS</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">SuperADS Channel Admin</a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <?php
                    $count_new = \common\models\Deliver::getTodayDeliver();

                    $name = 'pause';
                    $count_pause = CampaignStsUpdate::getCampaignUpdate($name);

                    $name = 'discount';
                    $count_discount = CampaignStsUpdate::getCampaignUpdate($name);

                    $name = 'payout';
                    $count_payout = CampaignStsUpdate::getCampaignUpdate($name);

                    $name = 'cap';
                    $count_cap = CampaignStsUpdate::getCampaignUpdate($name);

                    $name = 'update-creative';
                    $count_creative = CampaignStsUpdate::getCampaignUpdate($name);

                    $name = 'update-geo';
                    $count_geo = CampaignStsUpdate::getCampaignUpdate($name);

                    $count = $count_new + $count_geo + $count_pause + $count_discount + $count_payout + $count_cap + $count_creative;

                    echo '<span id= "lov-cvr" class="label label-warning"> '.$count.' </span>';
                    ?>
                </a>
                <ul class="dropdown-menu">
<!--                    <li class="header">Notifications</li>-->
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="/camp-log/campaign-update?name=pause">
                                    <?php

                                    echo '<i class="fa fa-pause text-yellow"></i>  '.$count_pause.' pausing offers';
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="/camp-log/deliver-new">
                                    <?php
                                    echo '<i class="fa fa-save text-aqua"></i> '.$count_new.' new offers';
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="/camp-log/campaign-update?name=discount">
                                    <?php
                                    echo '<i class="fa fa-save text-yellow"></i> '.$count_discount.'  update offers';
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="/camp-log/campaign-update?name=payout">
                                    <?php
                                    echo '<i class="fa fa-save text-aqua"></i>  '.$count_payout.' payout update';
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="/camp-log/campaign-update?name=cap">
                                    <?php
                                    echo '<i class="fa fa-save text-aqua"></i>  '.$count_cap.' cap update';
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="/camp-log/campaign-update?name=update-creative">
                                    <?php
                                    echo '<i class="fa fa-save text-aqua"></i>  '.$count_creative.' creative update';
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="/camp-log/campaign-update?name=update-geo">
                                    <?php
                                    echo '<i class="fa fa-save text-aqua"></i>  '.$count_geo.' GEO update';
                                    ?>
                                </a>
                            </li>
                        </ul>
                    </li>
<!--                    <li class="footer"><a href="#">View all</a></li>-->
                </ul>
            </li>
<!--            <li class="dropdown notifications-menu">-->
<!--                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >-->
<!--                    <i class="fa fa-bell-o"></i>-->
<!--                    --><?php
//                    $beginTheDayBefore=mktime(0,0,0,date('m'),date('d'),date('Y'));
//                    $data = \common\models\QualityAutoCheck::find()
//                        ->andFilterWhere(['>','create_time',$beginTheDayBefore])
//                        ->andFilterWhere(['channel_id' =>yii::$app->user->id])
//                        ->andFilterWhere(['is_send' =>0])
//                        ->all();
//                    $count = count($data);
//                    if ($count>0){
//                        echo '<span class="label label-warning">'.$count.'</span>';
//                    }
//                    ?>
<!--                </a>-->
<!--                <ul class="dropdown-menu">-->
<!--                    --><?php
//                    echo ' <a href="/channel-quality-report/index" data-menu="channel-quality">You have new quality report</a>';
//                    ?>
<!--                </ul>-->
<!--            </li>-->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    Welcome <?= Yii::$app->user->identity->username?> <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                 <li>
                     <a href="/site/reset-password-new" class="fa fa-user fa-fl">User Profile</a>
                    </li>
<!--                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>-->
<!--                    </li>-->
<!--                    <li class="divider"></li>-->
<!---->
<!--                    <li>-->
                        <?php
                        echo Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form']);
                        echo Html::endForm();
                        ?>
                        <?php
                        echo Html::beginTag("a", ['href' => '#', 'onclick' => 'document.getElementById("logout-form").submit();']);
                        echo Html::beginTag("i", ['class' => 'fa fa-sign-out fa-fw']);
                        echo Html::endTag("i");
                        echo 'Logout (' . Yii::$app->user->identity->username . ')';
                        //echo " Logout";
                        echo Html::endTag("a");
                        ?>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="../camp-log/index"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i> Offers<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?= Html::a('All Offers', ['camp-log/alloffers'],['data-menu'=>"alloffers"]) ?>
                            </li>

                            <li>
                                <?= Html::a('My Approved Offers', ['camp-log/myoffers'],['data-menu'=>"myoffers"]) ?>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?php //  Html::a('Hourly Report', ['my-report/hourly'],['data-menu'=>"hourly"]) ?>
                            </li>
                            <li>
                                <?php //  Html::a('Daily Report', ['my-report/daily'],['data-menu'=>"daily"]) ?>
                            </li>
                            <li>
                                <?=  Html::a('Offers Report', ['my-report/offers'],['data-menu'=>"offers"]) ?>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> Support<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/support/api" data-menu="channel-api">API</a>
                            </li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> Account<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/account/payment" data-menu="channel-payment">Payment</a>
                            </li>
                            <li>
                                <a href="/account/profile" data-menu="channel-profile">Profile</a>
                            </li>
                            <li>
                                <a href="#">Setting</a>
                            </li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <?= $content ?>
        </div>

    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
