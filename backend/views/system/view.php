<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\System */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="system-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'value',
            'name',
            'post_parameter:ntext',
            'mark',
            'note',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
