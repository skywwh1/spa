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
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
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
                    <a href="#">
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
                        <li><a href="/deliver/testlink" data-menu="testlink"><i class="fa fa-circle-o"></i>Test Link</a></li>
                        <li><a href="/deliver/index" data-menu="deliver_index"><i class="fa fa-circle-o"></i>S2S Log</a></li>
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
                        <li><a href="/campaign/index" data-menu="campaign_index"><i class="fa fa-circle-o"></i> Campaign List</a></li>
                        <li><a href="/campaign/create" data-menu="campaign_create"><i class="fa fa-circle-o"></i> Create Offer</a></li>
                        <li><a href="/apply-campaign/index" data-menu="apply-campaign-index"><i class="fa fa-circle-o"></i> Applying Offers</a></li>
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
                        <li><a href="/advertiser/index" data-menu="advertiser-index"><i class="fa fa-circle-o"></i> ADV List</a></li>
                        <li><a href="/advertiser/create" data-menu="advertiser_create"><i class="fa fa-circle-o"></i> Create ADV</a></li>
                        <li><a href="/advertiser-api/index" data-menu="advertiser-api-index"><i class="fa fa-circle-o"></i> Advertiser Api List</a></li>
                        <li><a href="/ip-table/index" data-menu="ip-table-index"><i class="fa fa-circle-o"></i> Advertiser IP List</a></li>

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
                        <li><a href="/channel/index" data-menu="channel_index"><i class="fa fa-circle-o"></i> Channel List</a></li>
                        <li><a href="/channel/my-channels" data-menu="my_channels"><i class="fa fa-circle-o"></i> My Channels</a></li>
                        <li><a href="/channel/applying" data-menu="applicants"><i class="fa fa-circle-o"></i> Applicant List</a></li>
                        <li><a href="/channel/create" data-menu="channel-create"><i class="fa fa-circle-o"></i> Create Channel</a></li>
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
                        <li><a href="/report/index"><i class="fa fa-circle-o"></i> Campaign Reports</a></li>
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
                        <li><a href="#"><i class="fa fa-circle-o"></i> Test</a>
                        </li>
                    </ul>
                </li>
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
