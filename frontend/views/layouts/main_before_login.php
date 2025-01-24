<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
    'options' => [
        'class' => 'navbar navbar-expand-md navbar-dark bg-success fixed-top',
    ],
]);

// Masukkan gambar ke dalam NavBar
echo '<div class="sidebar-header">';
echo Html::img(Yii::getAlias('@web') . '\img\Lancetrack_ambulance.png', ['alt' => 'Profile Picture', 'class' => 'sidebar-logo']);
echo '</div>';


    // Hanya menampilkan tombol Login dan Signup di navbar
    echo '<div class="navbar-nav ms-auto">';
    if (Yii::$app->user->isGuest) {
        echo Html::a('Login', ['/site/login'], ['class' => 'nav-link']);
        echo Html::a('Signup', ['/site/signup'], ['class' => 'nav-link ms-3']);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm();
    }
    echo '</div>';

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div id="backgroundCarousel" class="carousel slide position-absolute w-100 h-50 top-0 start-0" data-bs-ride="carousel" style="left: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px; overflow: hidden;">
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

    <div class="container position-relative" style="z-index: 1; margin-top: 50vh;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted position-relative bg-success" style="z-index: 1;">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<style>
#backgroundCarousel {
    z-index: -1; /* Place the carousel behind everything else */
    border-bottom-left-radius: 50px;
    border-bottom-right-radius: 50px;
    overflow: hidden;
}

.carousel-item img {
    object-fit: cover;
}

.site-login {
    position: relative;
    z-index: 1; /* Ensure the login form is above the background animation */
}

.welcome-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.welcome-text {
    font-size: 48px;
    font-weight: bold;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.features-container, .product-container, .info-container {
    display: none; /* Hide features and additional content */
}

.feature-box {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-bottom: 20px;
}

.navbar-brand {
    display: flex;
    align-items: center;
    height: 100%; /* Mengisi tinggi navbar */
}

.sidebar-logo {
    height: 40px; /* Sesuaikan tinggi logo dengan tinggi navbar */
    width: auto; /* Memastikan proporsi gambar tetap */
}
</style>
