<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Stream */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="stream-index"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'click_uuid',
            'click_id',
            'cp_uid',
            'ch.username',
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
        </div>
    </div>
</div
