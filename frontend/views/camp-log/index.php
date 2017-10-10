<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\MyCampaignLogDaily;
use common\models\Channel;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CampaignChannelLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'MyCampaign Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-channel-log-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Hello, <?php echo Yii::$app->user->identity->username ?>
                <p>
                    <small>
                        Welcome to our systerm
                        <?php
                        $model = Channel::findOne(Yii::$app->user->id);
                        echo ',' . $model->om0->username . ' is your account manager';
                        ?>
                    </small>
                </p>
            </h1>

        </div>
    </div>
    <p>
        <?php
        if (!empty($model->om0->avatar)) {
            $base = \common\models\User::getBaseUrl();
            echo '<img src=' . $base . $model->om0->avatar . ' style="width:100px; height:100px;class="img-circle" alt="OM"" />';
        }
        ?>
    </p>
    <?php
    $log = MyCampaignLogDaily::dailyReport();
    ?>
    <ul class="row list-unstyled">
        <li class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-9 text-left">
                            <div>Today's Total Revenue</div>
                            <div><var>
                                    <?php
                                    echo empty($log)?"":$log->revenue;
                                    ?>
                                </var></div>
                        </div>
                        <div class="col-xs-3 text-right">
                            <i class="fa fa-dollar  fa-2x"></i>
                        </div>
                    </div>
                </div>
                <a href="http://spa.com/my-report/offers">
                    <div class="panel-footer text-right">
                        View Detail
                        <i class="fa fa-arrow-circle-o-right "></i>
                    </div>
                </a>
            </div>
        </li>
        <li class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-9 text-left">
                            <div>Today's Total Unique Clicks</div>
                            <div><var>
                                    <?php
                                    echo empty($log)?"":$log->unique_clicks;
                                    ?>
                                </var></div>
                        </div>
                        <div class="col-xs-3 text-right">
                            <i class="glyphicon glyphicon-hand-up fa-2x"></i>
                        </div>
                    </div>
                </div>
                <a href="http://spa.com/my-report/offers">
                    <div class="panel-footer text-right">
                        View Detail
                        <i class="fa fa-arrow-circle-o-right "></i>
                    </div>
                </a>
            </div>
        </li>
        <li class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-9 text-left">
                            <div>Today's Total Leads</div>
                            <div><var><?php
                                    echo empty($log)?"":$log->installs;
                                    ?></var></div>
                        </div>
                        <div class="col-xs-3 text-right">
                            <i class="glyphicon glyphicon-download-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <a href="http://spa.com/my-report/offers" >
                    <div class="panel-footer text-right">
                        View Detail
                        <i class="fa fa-arrow-circle-o-right "></i>
                    </div>
                </a>
            </div>
        </li>
    </ul>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Analytics - Today's top campaigns
<!--                    <div class="pull-right">-->
<!--                        <div class="btn-group">-->
<!--                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"-->
<!--                                    aria-expanded="false">-->
<!--                                Actions-->
<!--                                <span class="caret"></span>-->
<!--                            </button>-->
<!--                            <ul class="dropdown-menu pull-right" role="menu">-->
<!--                                <li><a href="#">Action</a>-->
<!--                                </li>-->
<!--                                <li><a href="#">Another action</a>-->
<!--                                </li>-->
<!--                                <li><a href="#">Something else here</a>-->
<!--                                </li>-->
<!--                                <li class="divider"></li>-->
<!--                                <li><a href="#">Separated link</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
<!--                    <table class="table">-->
<!--                        <tr>-->
<!--                            <th style="color: #c30f2a">Campaign ID</th>-->
<!--                            <th style="color: #c30f2a">Revenue</th>-->
<!--                            <th style="color: #c30f2a">Clicks</th>-->
<!--                            <th style="color: #c30f2a">Unq.Clicks</th>-->
<!--                            <th style="color: #c30f2a">Conversions</th>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>888888</td>-->
<!--                            <td>$888</td>-->
<!--                            <td>88888</td>-->
<!--                            <td>8888</td>-->
<!--                            <td>8888</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>888888</td>-->
<!--                            <td>$888</td>-->
<!--                            <td>88888</td>-->
<!--                            <td>8888</td>-->
<!--                            <td>8888</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>888888</td>-->
<!--                            <td>$888</td>-->
<!--                            <td>88888</td>-->
<!--                            <td>8888</td>-->
<!--                            <td>8888</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>888888</td>-->
<!--                            <td>$888</td>-->
<!--                            <td>88888</td>-->
<!--                            <td>8888</td>-->
<!--                            <td>8888</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>888888</td>-->
<!--                            <td>$888</td>-->
<!--                            <td>88888</td>-->
<!--                            <td>8888</td>-->
<!--                            <td>8888</td>-->
<!--                        </tr>-->
<!--                    </table>-->
                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                    'campaign_id',
                                    'revenue',
                                    'clicks',
                                    'unique_clicks',
                                    'installs',
//                                [
//                                    'class' => 'yii\grid\ActionColumn', 'template' => '{view}',
//                                    'header' => 'Detail',
//                                ],
                            ],
                    ]); ?>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>

    <h4> Pls contact your account manager if you have any problems.</h4>
    <ul class="row list-unstyled">
        <li class="col-lg-3 col-md-6 <?php if (empty($model->om0->email)) {
            echo 'hide';
        } ?>">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-envelope-o fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4><?php echo empty($model->om0->email) ? '' : $model->om0->email; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="col-lg-3 col-md-6 <?php if (empty($model->om0->qq)) {
            echo 'hide';
        } ?>">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-qq fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4><?php echo empty($model->om0->qq) ? '' : $model->om0->qq; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="col-lg-3 col-md-6 <?php if (empty($model->om0->weixin)) {
            echo 'hide';
        } ?>">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-fa-wechat fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4><?php echo empty($model->om0->weixin) ? '' : $model->om0->weixin; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="col-lg-3 col-md-6 <?php if (empty($model->om0->skype)) {
            echo 'hide';
        } ?>">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-skype fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4><?php echo empty($model->om0->skype) ? '' : $model->om0->skype; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>


    <!--<ul>
        <li class="col-sm-3"><p> <?php /*echo  empty($model->om0->email)?'':'Email : '.$model->om0->email;*/ ?></p></li>
        <li class="col-sm-3"><p> <?php /*echo empty($model->om0->skype)?'':'Skype : '.$model->om0->skype;*/ ?></p></li>
        <li class="col-sm-3"><p> <?php /*echo empty($model->om0->weixin)?'':'Wechat : '.$model->om0->weixin;*/ ?></p></li>
        <li class="col-sm-3"><p> <?php /*echo  empty($model->om0->email)?'':'QQ : '.$model->om0->qq;*/ ?></p></li>
    </ul>-->


</div>