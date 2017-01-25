<?php

use yii\bootstrap\Progress;
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
<div id="nav-menu" data-menu="testlink"></div>
<div class="col-lg-12">
    <div class="box box-info">
        <div class="box-body">

        <?php $form = ActiveForm::begin([
            'id' => 'test-link-form',
            //'enableAjaxValidation' => true,
        ]); ?>

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
            <?= Html::button('Test', ['class' => 'btn btn-primary', 'onclick' => 'testPost();', '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<script type="application/javascript">
    function testPost() {
        $('#test-link-form').yiiActiveForm('validate');
        var $form = $("#test-link-form"), data = $form.data("yiiActiveForm");
        $.each(data.attributes, function () {
            this.status = 3;
        });
        $form.yiiActiveForm("validate");
        if ($("#test-link-form").find(".has-error").length) {
            return false;
        }

        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/deliver/testlink' ?>',
            type: 'post',
            data: {
                'TestLinkForm[tracking_link]': $('#testlinkform-tracking_link').val(),
                'TestLinkForm[channel]': $('#testlinkform-channel').val(),
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                alert(data);
                console.log(data);
            }
        });
    }
</script>
