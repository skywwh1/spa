<?php


/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = 'Api';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-api"></div>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">API key</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">

    <div class="col-lg-3">
        <pre><?= $model->auth_token ?></pre>

    </div>
</div>