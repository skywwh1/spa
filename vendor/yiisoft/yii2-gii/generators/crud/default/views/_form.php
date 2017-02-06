<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

                    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

                    <?php foreach ($generator->getColumnNames() as $attribute) {
                        if (in_array($attribute, $safeAttributes)) {
                            //  echo " <div class='form-group row'>\n";
                            // echo "   <div class='col-lg-4'>\n";
                            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n";
                            //  echo "   </div>\n";
                            // echo " </div>\n\n";
                        }
                    } ?>
                    <div class="form-group">
                        <?= "<?= " ?>Html::submitButton($model->isNewRecord
                        ? <?= $generator->generateString('Create') ?>
                        : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
                        'btn btn-primary']) ?>
                    </div>

                    <?= "<?php " ?>ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>