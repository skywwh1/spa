<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Advertiser */

$this->title = 'Update Advertiser: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Advertisers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="advertiser-update">

        <h3><?= Html::encode($this->title) ?></h3>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
