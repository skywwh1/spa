<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelBlack */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Channel Blacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="channel-black-index"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'advertiser_name',
            'channel_name',
//            'campaign_name',
            'geo',
            'os',
//            'action_type',
            [
                'attribute' => 'action_type',
                'value' => ModelsUtil::getBlackAction($model->action_type)
            ],
            'note:ntext',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
