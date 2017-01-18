<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Channel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-form">

    <?php $form = ActiveForm::begin(); ?>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'type')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'settlement_type')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'pm')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'om')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'master_channel')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'payment_way')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'payment_term')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'beneficiary_name')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'bank_country')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'bank_address')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'swift')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'account_nu_iban')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'company_address')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'system')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'created_time')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'updated_time')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'cc_email')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'qq')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'alipay')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'firstaccess')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'lastaccess')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'picture')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'confirmed')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'suspended')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'deleted')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'status')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'traffic_source')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'pricing_mode')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'post_back')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'total_revenue')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'payable')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'paid')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'strong_geo')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'strong_catagory')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
