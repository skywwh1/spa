<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LogEvent */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="log-event-view"></div>
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
            'click_uuid',
            'auth_token',
            'channel_id',
            'event_name',
            'event_value',
            'create_time:datetime',
            'update_time:datetime',
            'ip',
            'ip_long',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
