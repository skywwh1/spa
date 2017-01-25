<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = 'Create S2S';
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="STS"></div>
<div class="col-lg-12">
    <div class="box box-info">
        <div class="box-body">

        <?php $form = ActiveForm::begin(); ?>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'campaign_uuid')->widget(Typeahead::classname(), [
                    'options' => ['placeholder' => 'Campaign UUID'],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'remote' => [
                                'url' => Url::to(['campaign/campaigns_by_uuid']) . '?uuid=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ]],
                ])	?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'channel0')->widget(Typeahead::classname(), [
                    'options' => ['placeholder' => 'Channel'],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'remote' => [
                                'url' => Url::to(['channel/get_channel_name']) . '?name=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ]],
                ]) ?>
            </div>
        </div>
        <?= $form->field($model, 'step')->hiddenInput(['value'=>1])->label(false)?>
        <div class="form-group">
            <?= Html::submitButton('Go ahead', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div id="test_div"></div>
        </div>
    </div>
</div>