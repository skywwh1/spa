<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\NewMain;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

NewMain::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Super ADS</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="nav">
    <img src="<?= Yii::getAlias('@web/new/img/logo.png') ?>" alt=""/>
    <ul class="inright">
        <li><a href="<?= Url::to(['/site/contact'])?>">Contact</a></li>
        <li><a href="<?= Url::to(['/site/signup'])?>">Sign Up</a></li>
        <li><a href="<?= Url::to(['/site/login'])?>">Login</a></li>
    </ul>
    <ul id="LoutiNav">
        <li></li>
        <li><a href="<?= Url::to(['/site/index'])?>"><span>Advertisers</span></a></li>
        <li><span>Publishers</span></li>
        <li><span>Our Stats</span></li>
    </ul>
</div>
<div id="goTop">
    Top
</div>
<?= Alert::widget() ?>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
