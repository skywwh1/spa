<?php

use common\models\RegionsDomain;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChannelSignupForm */
/* @var $form ActiveForm */
$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1>Channel Signup</h1>

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Basic Info</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <?= $form->field($model, 'username') ?>
                            </div>
                            <div class="col-lg-3">
                                <?= $form->field($model, 'company') ?>
                            </div>
                            <div class="col-lg-3">
                                <?= $form->field($model, 'timezone')->dropDownList(ModelsUtil::timezone,['prompt'=>'Select time zone']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <?= $form->field($model, 'email') ?>
                            </div>
                            <div class="col-lg-3">
                                <?= $form->field($model, 'phone1') ?>
                            </div>
                            <div class="col-lg-3">
                                <?= $form->field($model, 'skype') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <?= $form->field($model, 'country')->dropDownList(RegionsDomain::getAllToArray(),['prompt'=>'Select region']) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $form->field($model, 'address') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Traffic Info</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'vertical') ?>
                        <?= $form->field($model, 'offer_type')->checkboxList(ModelsUtil::offerType) ?>
                        <?= $form->field($model, 'other_network') ?>
                        <?= $form->field($model, 'vertical_interested') ?>
                        <?= $form->field($model, 'special_offer') ?>
                        <?= $form->field($model, 'regions') ?>
                        <?= $form->field($model, 'traffic_type')->checkboxList(ModelsUtil::trafficType) ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Contact Preferences</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <?= $form->field($model, 'best_time')->input('text', ['placeholder' => "Preferred hours? eg: 9:00 am-12:00 am"]) ?>
                            </div>
                            <div class="col-lg-5">
                                <?= $form->field($model, 'time_zone')->dropDownList(ModelsUtil::timezone,['prompt'=>'Select time zone']) ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'suggested_am') ?>
                        <?= $form->field($model, 'additional_notes') ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Final Comments</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'another_info') ?>
                        <div class="row">

                            <div class="col-lg-3">
                                <?= $form->field($model, 'password_hash')->passwordInput() ?>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-3">
                                <?= $form->field($model, 'confirmPassword')->passwordInput() ?>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                    'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- aa -->

