<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
//        'css/main.css',
        'stylesheets/application-a07755f5.css',
        'stylesheets/font-awesome.css',
        //'//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css',
        'css/custom.css',
    ];
    public $js = [
        'javascripts/application-985b892b.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
