<?php

use common\models\Adminuser;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$model = User::findOne($id);

$this->title = '权限设置: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = '权限设置';
?>

<div id="nav-menu" data-menu="user-index"></div>
<div class="row">
    <div class="col-lg-5">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="user-index">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= Html::checkboxList('newPri', $AuthAssignmentArray, $allPrivilegesArray); ?>

                    <div class="form-group">
                        <?= Html::submitButton('设置') ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>




