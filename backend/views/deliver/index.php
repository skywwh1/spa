<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\DeliverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'S2S Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deliver-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'campaign.campaign_name',
            'channel.username',
            'pricing_mode',
            'pay_out',
            'daily_cap',
            // 'discount',
            // 'is_run',
            // 'creator',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'track_url:url',
            // 'note',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
