<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Stream */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'click_id',
            'cp_uid',
            'ch_id',
            'pl',
            'tx_id',
            'all_parameters',
            'ip',
            'redirect',
            'browser',
            'browser_type',
            'post_link',
            'post_status',
            'post_time:datetime',
            'is_count',
            'create_time:datetime',
        ],
    ]) ?>

</div>
