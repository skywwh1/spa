<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SbAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      //  'css/site.css',
        'vendor/bootstrap/css/bootstrap.min.css',
        'vendor/metisMenu/metisMenu.min.css',
        'dist/css/sb-admin-2.css',
        'vendor/morrisjs/morris.css',
        'vendor/font-awesome/css/font-awesome.min.css',
    ];
    public $js = [
//        'vendor/jquery/jquery.min.js',
        'vendor/bootstrap/js/bootstrap.min.js',
        'vendor/metisMenu/metisMenu.min.js',
        'vendor/raphael/raphael.min.js',
//        'vendor/morrisjs/morris.min.js',
//        'data/morris-data.js',
        'dist/js/dropdown.js',
        'dist/js/sb-admin-2.js',
        'dist/js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
