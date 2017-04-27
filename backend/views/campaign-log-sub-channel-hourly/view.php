<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignLogSubChannelHourly */

$this->title = $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Campaign Log Sub Channel Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="campaign-log-sub-channel-hourly-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id, 'sub_channel' => $model->sub_channel, 'time' => $model->time], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id, 'sub_channel' => $model->sub_channel, 'time' => $model->time], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'campaign_id',
            'channel_id',
            'sub_channel',
            'time:datetime',
            'time_format',
            'clicks',
            'unique_clicks',
            'installs',
            'match_installs',
            'redirect_installs',
            'redirect_match_installs',
            'pay_out',
            'adv_price',
            'daily_cap',
            'cap',
            'cost',
            'redirect_cost',
            'revenue',
            'redirect_revenue',
            'create_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
