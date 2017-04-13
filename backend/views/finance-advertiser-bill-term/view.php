<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTerm */

$this->title = $model->adv_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Bill Months', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-advertiser-bill-month-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'adv_id' => $model->adv_id, 'start_time' => $model->start_time, 'end_time' => $model->end_time], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'adv_id' => $model->adv_id, 'start_time' => $model->start_time, 'end_time' => $model->end_time], [
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
            'invoice_id',
            'adv_id',
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
            'receivable',
            'status',
            'update_time:datetime',
            'create_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
