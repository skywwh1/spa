<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parent_id',
            'username',
            'firstname',
            'lastname',
            'type',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'created_time:datetime',
            'updated_time:datetime',
            'status',
            'email:email',
            'company',
            'phone1',
            'phone2',
            'weixin',
            'qq',
            'skype',
            'alipay',
            'country',
            'city',
            'address',
            'lang',
            'timezone',
            'firstaccess',
            'lastaccess',
            'picture',
            'suspended',
            'deleted',
        ],
    ]) ?>

</div>
