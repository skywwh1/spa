<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Reset PassWord';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="user-reset"></div>
<div class="user-create">

    <div class="row">
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-body">
                    <div class="user-form">

                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-lg-6">

                                <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'weixin')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord
                                ? 'Create' : 'Reset', ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
                                'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
