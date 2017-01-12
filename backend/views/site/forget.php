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
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="login">
    <?php $this->beginBody() ?>
    <body class='login'>
    <div class='wrapper'>
        <div class='row'>
            <div class='col-lg-12'>
                <form>
                    <fieldset>
                        <legend>Reset your password</legend>
                    </fieldset>
                    <div class='form-group'>
                        <label class='control-label'>Email address</label>
                        <input class='form-control' placeholder='Enter your email address' type='text'>
                    </div>
                    <a class="btn btn-default" href="/">Send</a>
                    <a href="/">Go back</a>
                </form>
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