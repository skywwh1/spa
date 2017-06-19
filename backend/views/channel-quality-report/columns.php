<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\QualityDynamicColumn */

$this->title = 'Create Dynamic Columns';
$this->params['breadcrumbs'][] = ['label' => 'Create Dynamic Columns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'create-form',
]); ?>
<?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'sub_channel')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'time')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'name')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord
        ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
        'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
