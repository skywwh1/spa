<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="user-form">

                    <?php $form = ActiveForm::begin([
                        'options'=>['enctype'=>'multipart/form-data'] // important
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    <?php echo $form->field($model, 'filename');

                    // display the image uploaded or show a placeholder
                    // you can also use this code below in your `view.php` file
                    $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';
                    echo Html::img($model->getImageUrlAbs(), [
                        'class'=>'img-thumbnail',
                        'alt'=>$title,
                        'title'=>$title
                    ]);

                    // your fileinput widget for single file upload
                    echo $form->field($model, 'image')->widget(FileInput::classname(), [
                        'options'=>['accept'=>'image/*'],
                        'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],
                        ],
                    ]);
                    ?>
                    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'type')->textInput(['value'=>9]) ?>
                    <?= $form->field($model, 'status')->textInput() ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'weixin')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'qq')->textInput() ?>
                    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'alipay')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'firstaccess')->textInput() ?>
                    <?= $form->field($model, 'lastaccess')->textInput() ?>
                    <?= $form->field($model, 'picture')->textInput() ?>
                    <?= $form->field($model, 'suspended')->textInput(['value'=>0]) ?>
                    <?= $form->field($model, 'deleted')->textInput(['value'=>0]) ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord
                            ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
                            'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>