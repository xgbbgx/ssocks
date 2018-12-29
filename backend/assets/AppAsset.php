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
        'css/site/bootstrap.min.css',
        'css/site/bootstrap-responsive.min.css',
        'css/site/font-awesome.min.css',
        'css/site/style-metro.css',
        'css/site/style.css',
        'css/site/style-responsive.css',
        'css/site/default.css',
        'css/metronic/DT_bootstrap.css'
    ];
    public $js = [
        'js/jquery/jquery-1.10.2.min.js',
        'js/jquery/jquery-migrate-1.2.1.min.js',
        'js/metronic/bootstrap.min.js',
        'js/jquery/jquery.dataTables.min.js',
        'js/metronic/app.js',
        'js/wdialog/wdialog.js',
        'js/public.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
    //导入当前页的功能js文件，注意加载顺序，这个应该最后调用
    public static function addJs($view, $jsfile) {
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
    //css
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
}
