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
//        'admin/css/bootstrap.min.css',
        'admin/css/font-awesome.min.css',
        'admin/css/ionicons.min.css',
        'admin/css/select2.min.css',
        'admin/css/AdminLTE.min.css',
        'admin/css/skin-blue.min.css',
        'css/site.css',
    ];
    public $js = [
//        'admin/js/jquery-2.2.3.min.js',
//        'admin/js/bootstrap.min.js', // 注掉会引起菜单默认选择问题，不注掉，就会引起action dropdown问题
        'admin/js/fastclick.js',
        'admin/js/select2.full.min.js',
        'admin/js/dropdown.js', //表格和表单冲突
        'admin/js/jquery.cookie.js', //表格和表单冲突
        'admin/js/app.min.js',
//        'admin/js/demo.js',
        'admin/js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
