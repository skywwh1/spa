<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertiserApi */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="nav-menu" data-menu="advertiser-api_create"></div>
<div class="row">
    <div class="advertiser-api-index">
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-body">
                    <div class="advertiser-api-create">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'adv_id')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['value' => isset($model->adv) ? $model->adv->username : '',],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'remote' => [
                                        'url' => Url::to(['campaign/get_adv_list']) . '?name=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]],
                        ]) ?>
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder' => 'like: http://example.com/v4.php']) ?>
                        <?= $form->field($model, 'key')->textInput(['maxlength' => true, 'placeholder' => 'like : UDXBT02KMWXZYD8FBBWM']) ?>
                        <?= $form->field($model, 'param')->textInput(['maxlength' => true, 'placeholder' => 'like : m=index&cb=cb7654&time={time();}&token={md5("key".md5(time()));}']) ?>
                        <?= $form->field($model, 'json_offers_param')->textInput(['maxlength' => true, 'placeholder' => 'offers']) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="advertiser-api-index">
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-body">
                    <div class="advertiser-api-create">
                        <?= $form->field($model, 'campaign_id')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'campaign_uuid')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'pricing_mode')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'promote_start')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'end_time')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'adv_update_time')->textInput() ?>
                        <?= $form->field($model, 'effective_time')->textInput() ?>
                        <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'daily_cap')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'adv_price')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'payout_currency')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'daily_budget')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'now_payout')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'target_geo')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'adv_link')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'traffic_source')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'preview_link')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'package_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'app_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'app_size')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'app_rate')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'creative_link')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'creative_type')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'creative_description')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'carriers')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'conversion_flow')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>