<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RedirectLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Redirect Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="redirect-log-view"></div>
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
            'campaign_id_new',
            'daily_cap',
            'actual_discount',
            'discount',
            'discount_numerator',
            'discount_denominator',
            'status',
            'end_time:datetime',
            'create_time:datetime',
            'update_time:datetime',
            'creator',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
