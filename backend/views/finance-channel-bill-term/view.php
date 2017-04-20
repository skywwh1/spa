<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTerm */

$this->title = $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Channel Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-channel-bill-term-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bill_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bill_id], [
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
            'invoice_id',
            'period',
            'channel_id',
            'time_zone',
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
            'add_historic_cost',
            'pending',
            'deduction',
            'compensation',
            'add_cost',
            'final_cost',
            'actual_margin',
            'paid_amount',
            'payable',
            'apply_prepayment',
            'balance',
            'status',
            'note:ntext',
            'update_time:datetime',
            'create_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
