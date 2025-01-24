<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
?>
<div id="backgroundCarousel" class="carousel slide carousel-fade position-fixed w-100 h-100 top-0 start-0" data-bs-ride="carousel" style="left: 0; top: 0;">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/Ambulance2.jpg" class="d-block w-100 h-100" alt="First slide" style="object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="img/rumahsakit.png" class="d-block w-100 h-100" alt="Second slide" style="object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="img/rumahsakit2.jpg" class="d-block w-100 h-100" alt="Third slide" style="object-fit: cover;">
        </div>
    </div>
</div>

<div class="site-login d-flex justify-content-center align-items-center position-fixed top-0 start-0" style="width: 100%; height: 100%; margin: 0;">
    <div class="login-box shadowed-box position-relative">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <p class="text-center">Please fill out the following fields to login:</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="my-1 mx-0" style="color:#999;">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                <br>
                Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
            </div>

            <div class="form-group text-center">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
#backgroundCarousel {
    z-index: -1; /* Place the carousel behind everything else */
}

.carousel-item img {
    object-fit: cover;
}

.site-login {
    position: fixed; /* Fixed positioning to cover the whole viewport */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1; /* Ensure the login form is above the background animation */
}

.login-box {
    background-color: #ffffff; /* White background color */
    padding: 30px; /* Padding inside the box */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
    max-width: 400px; /* Set max width for the box */
    width: 100%; /* Ensure it takes full width on small screens */
    z-index: 2; /* Ensure the login box is above the background animation */
}
</style>
