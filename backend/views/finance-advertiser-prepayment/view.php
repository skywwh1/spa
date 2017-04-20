<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserPrepayment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Prepayments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-advertiser-prepayment-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'advertiser_bill_id',
            'advertiser_id',
            'timezone',
            'prepayment',
            'om',
            'note:ntext',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
