<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">

            <?php $form = ActiveForm::begin([
                'action' => ['search-channel'],
                'method' => 'get',
            ]); ?>
            <div class="box-body">
                <div class='col-lg-2'>
                    <?= $form->field($model, 'id') ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, 'username')->widget(Typeahead::classname(), [
                        'pluginOptions' => ['highlight' => true],
//                        'options' => ['value' => isset($model->master_channel) ? $model->masterChannel->username : '',],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['util/get-channel']) . '?name=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]],
                    ]) ?>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">

                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
