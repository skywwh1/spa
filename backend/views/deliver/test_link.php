<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\TestLinkForm */

$this->title = 'Test Link';
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-link">

    <div class="test-link-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'channel')->textInput() ?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'tracking_link')->textInput() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Test', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
