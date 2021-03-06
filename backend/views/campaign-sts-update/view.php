<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignStsUpdate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Campaign Sts Updates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="campaign-sts-update-view"></div>
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
            'name',
            'value',
            'type',
            'is_send',
            'send_time:datetime',
            'is_effected',
            'effect_time:datetime',
            'create_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
