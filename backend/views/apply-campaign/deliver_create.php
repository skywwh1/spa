<?php

use common\models\PriceModel;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = 'Update S2S: ' . $model->channel->username . '-' . $model->campaign->campaign_uuid;
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign->campaign_uuid, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<?php $form = ActiveForm::begin([
    'id' => 'approve-form',
]); ?>
<?= $form->field($model, 'campaign_uuid')->textInput(['readonly' => true]) ?>
<?= $form->field($model, 'channel0')->textInput(['readonly' => true, 'value' => $model->channel->username]) ?>
<?= $form->field($model, 'pricing_mode')->dropDownList(
    PriceModel::find()
        ->select(['name', 'value'])
        ->orderBy('id')
        ->indexBy('value')
        ->column()
) ?>
<?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'note')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'kpi')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'others')->hiddenInput()->label(false) ?>
    <div class="col-lg-12">
        <div class="form-group col-lg-4">
            <label class="control-label">Adv price:</label>
        </div>
        <div class="form-group col-lg-4">
            <label class="control-label"><?= $model->adv_price ?></label>
        </div>
    </div>
<?= $form->field($model, 'pay_out')->textInput() ?>
<?= $form->field($model, 'daily_cap')->textInput() ?>
<?= $form->field($model, 'discount')->textInput() ?>
<?php //$form->field($model, 'is_run')->dropDownList(ModelsUtil::status) ?>

    <div class="form-group">
        <?= Html::submitButton('Approve', ['class' => 'btn btn-success']) ?>
        <?= Html::button('Reject', ['class' => 'btn btn-danger','id'=>'campaignRejectButton']) ?>
    </div>

<?php ActiveForm::end(); ?>