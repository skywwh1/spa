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
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>Sign in</title>
    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <?php $this->head() ?>
</head>
<body class='login'>
<div class='wrapper'>
    <div class='row'>
        <div class='col-lg-12'>
            <div class='brand text-center'>
                <h1>
                    <div class='logo-icon'>
                        <i class='icon-beer'></i>
                    </div>
                    Hierapolis
                </h1>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-12'>
            <form>
                <fieldset class='text-center'>
                    <legend>Login to your account</legend>
                    <div class='form-group'>
                        <input class='form-control' placeholder='Email address' type='text'>
                    </div>
                    <div class='form-group'>
                        <input class='form-control' placeholder='Password' type='password'>
                    </div>
                    <div class='text-center'>
                        <div class='checkbox'>
                            <label>
                                <input type='checkbox'>
                                Remember me on this computer
                            </label>
                        </div>
                        <a class="btn btn-default" href="dashboard.html">Sign in</a>
                        <br>
                        <a href="forgot_password.html">Forgot password?</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</body>
</html>
