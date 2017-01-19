<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class='main page'>
<?php $this->beginBody() ?>

<!-- Navbar -->
<div class='navbar navbar-default' id='navbar'>
    <a class='navbar-brand' href='#'>
        <i class='icon-beer'></i>
        Super ADS
    </a>
    <ul class='nav navbar-nav pull-right'>
        <li class='dropdown'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                <i class='icon-envelope'></i>
                Messages
                <span class='badge'>5</span>
                <b class='caret'></b>
            </a>
            <ul class='dropdown-menu'>
                <li>
                    <a href='#'>New message</a>
                </li>
                <li>
                    <a href='#'>Inbox</a>
                </li>
                <li>
                    <a href='#'>Out box</a>
                </li>
                <li>
                    <a href='#'>Trash</a>
                </li>
            </ul>
        </li>
        <li>
            <a href='#'>
                <i class='icon-cog'></i>
                Settings
            </a>
        </li>
        <li class='dropdown user'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                <i class='icon-user'></i>
                <strong><?= Yii::$app->user->identity->username ?></strong>
                <b class='caret'></b>
            </a>
            <ul class='dropdown-menu'>
                <li>
                    <a href='#'>Edit Profile</a>
                </li>
                <li class='divider'></li>
                <li>
                    <?php $aa = '<a>' .
                        Html::beginForm(['/site/logout'], 'post') .
                        Html::submitButton(
                            'Logout',
                            ['class' => 'btn-link', 'style' => 'color: #ecf0f1']
                        ) .
                        Html::endForm() . '</a>';
                    echo $aa;
                    ?>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div id='wrapper'>
    <!-- Sidebar -->
    <section id='sidebar'>
        <i class='icon-align-justify icon-large' id='toggle'></i>
        <ul id='dock'>
            <li class='launcher dropdown hover  '>
                <i class='icon-dashboard'></i>
                <a href="#">Tools</a>
                <ul class='dropdown-menu'>
                    <li>
                        <?= Html::a('S2S', ['deliver/create']) ?>
                    </li>
                    <li>
                        <?= Html::a('Test Link', ['deliver/testlink']) ?>
                    </li>
                    <li>
                        <?= Html::a('S2S Log', ['deliver/index']) ?>
                    </li>
                </ul>
            </li>
            <li class='launcher dropdown hover'>
                <i class='icon-file-text-alt'></i>
                <?= Html::a('Offers', ['campaign/index']) ?>
                <ul class='dropdown-menu'>
                    <li>
                        <?= Html::a('Create Offer', ['campaign/create']) ?>
                    </li>
                </ul>
            </li>
            <li class='launcher dropdown hover'>
                <i class='icon-table'></i>
                <?= Html::a('ADV', ['advertiser/index']) ?>
                <ul class='dropdown-menu'>
                    <li>
                        <?= Html::a('ADV List', ['advertiser/index']) ?>
                    </li>
                    <li>
                        <?= Html::a('Create ADV', ['advertiser/create']) ?>
                    </li>
                </ul>
            </li>
            <li class='launcher dropdown hover'>
                <i class='icon-table'></i>
                <?= Html::a('Channel', ['channel/index']) ?>
                <ul class='dropdown-menu'>
                    <li><?= Html::a('Channel List', ['channel/index']) ?></li>
                    <li>
                        <?= Html::a('Create Channel', ['channel/create']) ?>
                    </li>
                </ul>
            </li>
            <li class='launcher dropdown hover'>
                <i class='icon-flag'></i>
                <a href='#'>Reports</a>
                <ul class='dropdown-menu'>
                    <li>
                        <?= Html::a('Report List', ['report/index']) ?>
                    </li>
                </ul>
            </li>
            <li class='launcher'>
                <i class='icon-bookmark'></i>
                <a href='#'>Finance</a>
            </li>
            <!--
          <li class='launcher'>
              <i class='icon-cloud'></i>
              <a href='#'>Backup</a>
          </li>
          <li class='launcher'>
              <i class='icon-bug'></i>
              <a href='#'>Feedback</a>
          </li>-->
        </ul>
        <div data-toggle='tooltip' id='beaker' title='Made by Iven'></div>
    </section>
    <!-- Tools -->
    <section id='tools'>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </section>
    <!-- Content -->
    <div id='content'>
        <!--<div class="panel panel-default grid">-->
        <?= Alert::widget() ?>
        <?= $content ?>
        <!--</div>-->

        <!-- Footer -->
        <div>
            <div class='page-header'>
                <h4></h4>
            </div>
            <div class='row text-center'>
                <p class="pull-left">&copy; Superads <?= date('Y') ?></p>
                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </div>
    </div>
</div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
