<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Channel;
/* @var $this yii\web\View */

$this->title = 'MyCampaign Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-channel-log-index">

        <h1>Hello, <?php echo Yii::$app->user->identity->username?></h1>
        <p>Welcome to our systerm</p>
<!--        <div class="pull-left">-->
<!--            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="OM">-->
<!--        </div>-->
        <p>
            <?php
              $model = Channel::findOne(Yii::$app->user->id);
              echo $model->om0->username.' is your account manager';
            ?>
        </p>
        <p> <?php echo  empty($model->om0->email)?'':'Email : '.$model->om0->email;?></p>
        <p> <?php echo empty($model->om0->skype)?'':'Skype : '.$model->om0->skype;?></p>
        <p> <?php echo empty($model->om0->weixin)?'':'Wechat : '.$model->om0->weixin;?></p>
        <p> <?php echo  empty($model->om0->email)?'':'QQ : '.$model->om0->qq;?></p>
        <p> Pls contact your account manager if you have any problems.</p>
</div>