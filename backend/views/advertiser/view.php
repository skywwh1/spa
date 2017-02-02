<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Advertiser */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Advertisers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="advertiser-view">

        <h3><?= Html::encode($this->title) ?></h3>

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
                'username',
//            'team',
                //'settlement_type',
                [
                    'attribute' => 'settlement_type',
                    'value' => ModelsUtil::getValue(ModelsUtil::settlement_type, $model->settlement_type),
                ],
                // 'bd',
                [
                    'attribute' => 'bd',
                    'value' => $model->bd0->username,
                ],
                //'system',
                [
                    'attribute' => 'system',
                    'value' => ModelsUtil::getValue(ModelsUtil::system, $model->system),
                ],
                //'status',
                [
                    'attribute' => 'status',
                    'value' => ModelsUtil::getValue(ModelsUtil::advertiser_status, $model->status),
                ],
                'contacts',
                //'pricing_mode',
                [
                    'attribute' => 'pricing_mode',
                    'value' => ModelsUtil::getValue(ModelsUtil::pricing_mode, $model->pricing_mode),
                ],
                //'created_time:datetime',
                [
                    'attribute' => 'created_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                //'updated_time:datetime',
                [
                    'attribute' => 'updated_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                'email:email',
                'company',
                'phone1',
                'skype',
                'country',
                'city',
                'firstaccess',
                'lastaccess',
                'picture',
                // 'suspended',
                [
                    'attribute' => 'suspended',
                    'value' => ModelsUtil::getValue(ModelsUtil::user_status, $model->suspended),
                ],
                [
                    'attribute' => 'deleted',
                    'value' => ModelsUtil::getValue(ModelsUtil::user_status, $model->deleted),
                ],
                //'deleted',
                'cc_email:email',
                'note:ntext',
            ],
        ]) ?>

    </div>
</div>
