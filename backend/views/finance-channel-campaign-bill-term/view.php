<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelCampaignBillTerm */

$this->title = $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Channel Campaign Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-channel-campaign-bill-term-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'bill_id' => $model->bill_id, 'campaign_id' => $model->campaign_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'bill_id' => $model->bill_id, 'campaign_id' => $model->campaign_id], [
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
            'bill_id',
            'channel_id',
            'time_zone',
            'campaign_id',
            'start_time:datetime',
            'end_time:datetime',
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
            'note:ntext',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
