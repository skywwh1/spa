<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="main">
        <div class="louceng box clearfix">
            <div class="slider">
                <ul>
                    <li><img src="<?= Yii::getAlias('@web/new/img/banner1.png') ?>"/></li>
                    <li><img src="<?= Yii::getAlias('@web/new/img/banner2.png') ?>"/></li>
                    <li><img src="<?= Yii::getAlias('@web/new/img/banner3.png') ?>"/></li>
                    <li><img src="<?= Yii::getAlias('@web/new/img/banner1.png') ?>"/></li>
                </ul>
            </div>
            <div class="arror"></div>
        </div>
        <div class="louceng Tingkou clearfix" style="background: #D6D6D6;">
            <img src="<?= Yii::getAlias('@web/new/img/advertisers-bg.png') ?>"/>
            <div class="T-left">
                <img src="<?= Yii::getAlias('@web/new/img/earth.png') ?>"/>
            </div>
            <div class="T-right">
                <h1><strong>A</strong>dvertisers</h1>
                <p>Whether you want to promote an app in a certain country
                    or want to reach global audiences, we designed a full set
                    of tools that will match your advertising needs.
                    Boost your user value now!</p>
                <a href="#"><input type="button" name="" id="" value="SIGN  UP"/></a>
            </div>
        </div>
        <div class="louceng Housebn clearfix" style="background: #D6D6D6;">
            <div class="H-left">
                <h1><strong>P</strong>ublishers</h1>
                <p>Maximize your revenues with SuperADS. We built a solid
                    and reliable platform to target the most appropriate ad
                    for your audience, getting you highest eCPMs.
                    Maximize your audience potential now!</p>
                <a href="<?= Url::to(['/site/signup'])?>"><input type="button" name="" id="" value="SIGN  UP"/></a>
            </div>
            <div class="H-right">
                <img src="<?= Yii::getAlias('@web/new/img/details.png') ?>"/>
            </div>
        </div>
        <div class="louceng Crousel clearfix" style="background: #D6D6D6;">
            <h1><strong>O</strong>ur <strong>S</strong>tats</h1>
            <div class="C-con">
                <div>
                    <img src="<?= Yii::getAlias('@web/new/img/DAILY.png') ?>"/>
                    <p>280,618,888</p>
                    <h2>DAILY IMPRESSIONS</h2>
                </div>
                <div>
                    <img src="<?= Yii::getAlias('@web/new/img/ACTIVE.png') ?>"/>
                    <p>228</p>
                    <h2>ACTIVE GEOS</h2>
                </div>
                <div>
                    <img src="<?= Yii::getAlias('@web/new/img/CAMPAIGNS.png') ?>"/>
                    <p>3,000</p>
                    <h2>LIVE CAMPAIGNS</h2>
                </div>
            </div>
        </div>
        <div class="footer">
            <h3>&copy;Super ADS 2017</h3>
            <p>Powered by <strong>SuperADS Tech</strong></p>
        </div>
    </div>
<?php
$this->registerJsFile(
    '@web/new/js/index.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>