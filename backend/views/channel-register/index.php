<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelRegisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Registers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-register-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Channel Register', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'channel_id',
            'vertical',
            'offer_type',
            'other_network',
            // 'vertical_interested',
            // 'special_offer',
            // 'regions',
            // 'traffic_type',
            // 'best_time',
            // 'time_zone',
            // 'suggested_am',
            // 'additional_notes',
            // 'another_info',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
