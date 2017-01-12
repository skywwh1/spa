<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Sign Up';
?>
<div class="user-signup">

    <?= $this->render('signup_form', [
        'model' => $model,
    ]) ?>

</div>
