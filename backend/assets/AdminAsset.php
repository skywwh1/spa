<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
//        'admin/css/bootstrap.min.css',
        'admin/css/font-awesome.min.css',
        'admin/css/ionicons.min.css',
        'admin/css/select2.min.css',
        'admin/css/AdminLTE.min.css',
        'admin/css/skin-blue.min.css',
    ];
    public $js = [
//        'admin/js/jquery-2.2.3.min.js',
        'admin/js/bootstrap.min.js',
        'admin/js/select2.full.min.js',
        'admin/js/app.min.js',
        'admin/js/demo.js',
        'admin/js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
