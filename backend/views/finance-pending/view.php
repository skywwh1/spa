<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Pendings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-pending-view"></div>
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
            'campaign_id',
            'channel_id',
            'start_date',
            'end_date',
            'installs',
            'match_installs',
            'adv_price',
            'pay_out',
            'cost',
            'revenue',
            'margin',
            'adv',
            'pm',
            'bd',
            'om',
            'status',
            'note:ntext',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
