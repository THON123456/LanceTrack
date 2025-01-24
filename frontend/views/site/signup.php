<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
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

<div class="site-signup d-flex justify-content-center align-items-center position-fixed top-0 start-0" style="width: 100%; height: 100%; margin: 0;">
    <div class="signup-box shadowed-box position-relative">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <p class="text-center">Please fill out the following fields to signup:</p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
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

.site-signup {
    position: fixed; /* Fixed positioning to cover the whole viewport */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
}

.signup-box {
    background-color: #ffffff; /* White background color */
    padding: 30px; /* Padding inside the box */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
    max-width: 400px; /* Set max width for the box */
    width: 100%; /* Ensure it takes full width on small screens */
    z-index: 2; /* Ensure the signup box is above the background animation */
}
</style>
