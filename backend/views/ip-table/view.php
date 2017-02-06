<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\IpTable */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ip Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="ip-table-index"></div>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="ip-table-view">

                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'value',
                            'mark',
                            'note:ntext',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>