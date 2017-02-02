<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = 'Create Channel';
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>