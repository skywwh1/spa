<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class='hold-transition skin-blue sidebar-mini'>
<?php $this->beginBody() ?>

<div class="wrapper" style="height: auto;">
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>PA</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Super</b>ADS</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" id="a-sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <?php
                            $data = \common\models\ApplyCampaign::find()->leftJoin('channel','apply_campaign.channel_id = channel.id')->andFilterWhere(['channel.om' =>yii::$app->user->id])->andFilterWhere(['apply_campaign.status' => 1])->all();
                            $count = count($data);
                             echo '<span class="label label-warning">'.$count.'</span>';
                            ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            echo '<li class="header">You have '. $count.' applying offers</li>';
                            ?>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/user/reset-password" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <?php $aa = '<a>' .
                                        Html::beginForm(['/site/logout'], 'post') .
                                        Html::submitButton(
                                            'Sign out',
                                            ['class' => 'btn btn-default btn-flat']
                                        ) .
                                        Html::endForm() . '</a>';
                                    echo $aa;
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <!-- sidebar menu: : Dashboard -->
                <li>
                    <a href="/site/info" data-menu="site-info">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-wrench"></i> <span>Tools</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/deliver/create" data-menu="STS"><i class="fa fa-circle-o"></i>S2S</a></li>
                        <li><a href="/deliver/testlink" data-menu="testlink"><i class="fa fa-circle-o"></i>Test Link</a>
                        </li>
                        <li><a href="/deliver/index" data-menu="deliver_index"><i class="fa fa-circle-o"></i>S2S Log</a>
                        </li>
                        <li><a href="/redirect-log/index" data-menu="redirect-log-index"><i class="fa fa-circle-o"></i>Redirect
                                Log</a></li>
                        <li><a href="/campaign-sub-channel-log-redirect/index" data-menu="campaign-sub-channel-log-redirect-index"><i class="fa fa-circle-o"></i>Sub Redirect
                                Log</a></li>
                        <li><a href="/campaign-sts-update/index" data-menu="campaign-sts-update-index"><i class="fa fa-circle-o"></i>Payout Log
                                </a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Offers</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/campaign/index" data-menu="campaign_index"><i class="fa fa-circle-o"></i> Campaign
                                List</a></li>
                        <li><a href="/campaign/cpa-index" data-menu="campaign_cpa"><i class="fa fa-circle-o"></i> CPA
                                List</a></li>
                        <li><a href="/campaign/api-index" data-menu="campaign_api"><i class="fa fa-circle-o"></i> ASXMI
                                List</a></li>
                        <li><a href="/campaign/mundo-index" data-menu="mundo_api"><i class="fa fa-circle-o"></i> Mundo
                                List</a></li>
                        <li><a href="/campaign/create" data-menu="campaign_create"><i class="fa fa-circle-o"></i> Create
                                Offer</a></li>
                        <li><a href="/apply-campaign/index" data-menu="apply-campaign-index"><i
                                        class="fa fa-circle-o"></i> Applying Offers</a></li>
                        <li><a href="/api-campaign/index" data-menu="api-campaign-index"><i class="fa fa-circle-o"></i>
                                API Offers</a></li>
                        <li><a href="/stream/index" data-menu="stream-index"><i class="fa fa-circle-o"></i> Post records</a>
                        </li>
                        <li><a href="/my-cart/index" data-menu="my-cart-index"><i class="fa fa-circle-o"></i> My Cart</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th"></i> <span>ADV</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/advertiser/index" data-menu="advertiser-index"><i class="fa fa-circle-o"></i> ADV
                                List</a></li>
                        <li><a href="/advertiser/create" data-menu="advertiser_create"><i class="fa fa-circle-o"></i>
                                Create ADV</a></li>
                        <li><a href="/advertiser-api/index" data-menu="advertiser-api-index"><i
                                        class="fa fa-circle-o"></i> Advertiser Api List</a></li>
                        <li><a href="/ip-table/index" data-menu="ip-table-index"><i class="fa fa-circle-o"></i>
                                Advertiser IP List</a></li>

                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Channel</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                        if (Yii::$app->user->can('admin')) {
                            ?>
                            <li><a href="/channel/index" data-menu="channel_index"><i class="fa fa-circle-o"></i>
                                    Channel
                                    List</a></li>
                        <?php } ?>
                        <li><a href="/channel/my-channels" data-menu="my_channels"><i class="fa fa-circle-o"></i> My
                                Channels</a></li>
                        <li><a href="/channel/applying" data-menu="applicants"><i class="fa fa-circle-o"></i> Applicant
                                List</a></li>
                        <li><a href="/channel/create" data-menu="channel-create"><i class="fa fa-circle-o"></i> Create
                                Channel</a></li>
                        <li><a href="/channel-black/index" data-menu="channel-black-index"><i class="fa fa-circle-o"></i> Channel
                                BlackList</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Reports</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/report/report-adv" data-menu="report-adv"><i class="fa fa-circle-o"></i> ADV
                                Reports</a></li>
                        <li><a href="/report/report-channel" data-menu="report-channel"><i class="fa fa-circle-o"></i>
                                Channel Reports</a></li>
                        <li><a href="/report/report-sub-channel" data-menu="report-sub-channel"><i class="fa fa-circle-o"></i>
                               Sub Channel Reports</a></li>
                        <?php
                        if (Yii::$app->user->can('admin')) {
                            ?>
                            <li><a href="/report/report-summary" data-menu="report-summary"><i class="fa fa-circle-o"></i>
                                    Summary Reports</a></li>
                        <?php } ?>
                        <li><a href="/report/index" data-menu="report-index"><i class="fa fa-circle-o"></i> Campaign
                                Reports</a></li>
                        <li><a href="/log-feed/index" data-menu="log-feed-index"><i class="fa fa-circle-o"></i> Match
                                Installs</a></li>
                        <li><a href="/log-post/index" data-menu="log-post-index"><i class="fa fa-circle-o"></i> Installs</a>
                        </li>
                        <li><a href="/channel-quality-report/index" data-menu="channel-quality-report-index"><i class="fa fa-circle-o"></i>
                                Channel Quality Reports</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Finance</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/finance-pending/index" data-menu="finance-pending-index"><i
                                        class="fa fa-circle-o"></i> Pending List</a></li>
                        <li><a href="/finance-deduction/index" data-menu="finance-deduction-index"><i
                                        class="fa fa-circle-o"></i> Deduction List</a></li>
                        </li>
                        <li><a href="/finance-compensation/index" data-menu="finance-compensation-index"><i class="fa fa-circle-o"></i> Compensation List</a></li>
                        </li>
                        </li>
                        <li><a href="/finance-advertiser-bill-term/index" data-menu="finance-advertiser-bill-month-index"><i class="fa fa-circle-o"></i> Advertiser Receivable</a></li>
                        </li>
                        </li>
                        <li><a href="/finance-channel-bill-term/index" data-menu="finance-channel-bill-term-index"><i class="fa fa-circle-o"></i> Channel Payable</a></li>
                        </li>
                    </ul>
                </li>
                <?php
                if (Yii::$app->user->can('admin')) {
                    ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-edit"></i> <span>Users</span>
                            <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/user/index" data-menu="user-index"><i class="fa fa-circle-o"></i> User
                                    List</a></li>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </section>

        <section class="content">
            <?= $content ?>
        </section>
    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Powered by</b> Superads 2017
        </div>
        <strong>Copyright &copy;</strong>Superads 2017
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
