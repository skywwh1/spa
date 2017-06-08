<?php

use common\models\PriceModel;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $delivers common\models\Deliver[] */

$this->title = 'Create S2S';
$this->params['breadcrumbs'][] = ['label' => 'S2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="STS"></div>
<?php
if (!is_null($returnMsg)) {
//    echo "<script> var returnMsg = \"$returnMsg\";</script>" ;
    echo("<script>var returnMsg = \"$returnMsg\";
    if(returnMsg.indexOf('Cannot S2S') != -1){
        alert(returnMsg);
        location.href='/deliver/create';}
    else{
    if(confirm( returnMsg)) ;
    else location.href='/deliver/create';
    }</script>");
//    echo("<script>if(confirm( \"$returnMsg\")) ;else location.href='/deliver/create'; </script>");
}
if (!is_null($delivers)) {
    $i = 0;
    foreach ($delivers as $deliver) {
        if ($i % 2 == 0) {
            echo '<div class="row">';
        }
        ?>
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Offer <?= $deliver->campaign->campaign_name ?> to <?= $deliver->channel0 ?></h3>
                </div>
                <div class="box-body">

                    <?php $form = ActiveForm::begin([
                        'id' => $deliver->formName() . 'form' . $i,
                        'action' => ['/deliver/sts-create'],
                        'options' => ['class' => 'sts_form'],
                    ]); ?>

                    <?= $form->field($deliver, 'campaign_uuid')->textInput(['readonly' => true]) ?>
                    <?= $form->field($deliver, 'channel0')->textInput(['readonly' => true]) ?>
                    <?= $form->field($deliver, 'pricing_mode')->dropDownList(
                        PriceModel::find()
                            ->select(['name', 'value'])
                            ->orderBy('id')
                            ->indexBy('value')
                            ->column()
                    ) ?>
                    <div class="col-lg-12">
                        <div class="form-group col-lg-4">
                            <label class="control-label">Adv price:</label>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="control-label"><?= $deliver->adv_price ?></label>
                        </div>
                    </div>
                    <?= $form->field($deliver, 'pay_out')->textInput() ?>
                    <?= $form->field($deliver, 'daily_cap')->textInput() ?>

                    <?php
                    if(empty($deliver->discount)){
                        echo $form->field($deliver, 'discount')->textInput(['value' => 30]);
                    }else{
                        echo $form->field($deliver, 'discount')->textInput();
                    }
                    ?>

                    <?= $form->field($deliver, 'is_send_create')->dropDownList([
                        '0' => 'Yes',
                        '1' => 'No',
                    ]) ?>
                    <?= $form->field($deliver, 'kpi')->textarea(['rows' => 1]) ?>
                    <?= $form->field($deliver, 'note')->textarea() ?>
                    <?= $form->field($deliver, 'others')->textarea(['rows' => 1]) ?>

                    <?= $form->field($deliver, 'step')->hiddenInput(['value' => 2])->label(false) ?>
                    <?= $form->field($deliver, 'campaign_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($deliver, 'channel_id')->hiddenInput()->label(false) ?>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>


        <?php
        if ($i % 2 != 0) {
            echo '</div>';
        }
        $i++;
    }
}
?>
<?php Modal::begin([
    'id' => 'campaign-detail-modal',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="campaign-detail-content"></div>';

Modal::end(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-footer">
                <button type="button" class="btn btn-primary" id="submit-button">Submit</button>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    'id' => 'black-channel-modal',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="black-channel-content"></div>';

Modal::end(); ?>
<?php
$this->registerJsFile(
    '@web/js/sts.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>