<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use backend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width = device-width, initial-scale = 1">
        <?= Html::csrfMetaTags() ?>
        <title>Superads login</title>
        <?php $this->head() ?>
    </head>

    <body class="login">
    <?php $this->beginBody() ?>
    <div class='wrapper'>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='brand text-center'>
                    <h1>
                        <div class='logo-icon'>
                            <i class='icon-beer'></i>
                        </div>
                        Super ADS
                    </h1>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12'>
                <?= $content ?>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">© SuperADS <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>