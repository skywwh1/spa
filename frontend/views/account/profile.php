<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-profile"></div>

<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">Profile</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">


    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt><?= $model->getAttributeLabel("company") ?> :</dt>
                    <dd><?= $model->company ?></dd>
                    <dt><?= $model->getAttributeLabel("firstname") ?> :</dt>
                    <dd><?= $model->firstname ?></dd>
                    <dt><?= $model->getAttributeLabel("lastname") ?> :</dt>
                    <dd><?= $model->lastname ?></dd>
                    <dt><?= $model->getAttributeLabel("phone1") ?> :</dt>
                    <dd><?= $model->phone1 ?></dd>
                    <dt><?= $model->getAttributeLabel("skype") ?> :</dt>
                    <dd><?= $model->skype ?></dd>
                    <dt><?= $model->getAttributeLabel("email") ?> :</dt>
                    <dd><?= $model->email ?></dd>
                    <dt><?= $model->getAttributeLabel("company_address") ?> :</dt>
                    <dd><?= $model->company_address ?></dd>
                </dl>
            </div>
            <div class="panel-footer">
                <p>
                    <?= Html::a('Update', ['update-profile'], ['class' => 'btn btn-primary btn-sm']) ?>
                </p>
            </div>
        </div>

    </div>
</div>

