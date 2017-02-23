<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-payment"></div>

<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">Payment</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">


    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt><?= $model->getAttributeLabel("payment_way") ?> :</dt>
                    <dd><?= $model->payment_way ?></dd>
                    <dt><?= $model->getAttributeLabel("beneficiary_name") ?> :</dt>
                    <dd><?= $model->beneficiary_name ?></dd>
                    <dt><?= $model->getAttributeLabel("bank_country") ?> :</dt>
                    <dd><?= $model->bank_country ?></dd>
                    <dt><?= $model->getAttributeLabel("bank_name") ?> :</dt>
                    <dd><?= $model->bank_name ?></dd>
                    <dt><?= $model->getAttributeLabel("bank_address") ?> :</dt>
                    <dd><?= $model->bank_address ?></dd>
                    <dt><?= $model->getAttributeLabel("swift") ?> :</dt>
                    <dd><?= $model->swift ?></dd>
                    <dt><?= $model->getAttributeLabel("account_nu_iban") ?> :</dt>
                    <dd><?= $model->account_nu_iban ?></dd>
                </dl>
            </div>
            <div class="panel-footer">
                <p>
                    <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary btn-sm']) ?>
                </p>
            </div>
        </div>

    </div>
</div>

