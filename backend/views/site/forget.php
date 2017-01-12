<?php
use yii\helpers\Html;
?>
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
                <?= Html::a('Go back', ['index']) ?>
            </form>
        </div>
    </div>
</div>
