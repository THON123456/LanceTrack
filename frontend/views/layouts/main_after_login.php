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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
      .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    padding: 15px;
    background: linear-gradient(180deg, #198754 20%, #3BAF7D 50%); /* Gradasi dari hijau ke putih */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 5);
    z-index: 1050;
}

        .main-content {
            margin-left: 270px;
            padding-top: 60px;
        }
        .navbar-fixed-top {
            margin-left: 250px;
            z-index: 1040;
        }
        .footer {
            margin-left: 250px;
        }
        .sidebar img {
            max-width: 80%;
            height: auto;
            border-radius: 0%;
        }
        .sidebar .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: #ffff;
            margin: 10px 0;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            padding: 10px 5px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4); /* Bayangan teks */
        }
        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .sidebar .nav-link .fa {
            margin-right: 15px;
            font-size: 20px;
        }
        .sidebar .nav-link span {
            padding-left: 10px;
        }
        .navbar-custom {
            background-color: #278A5B;
        }
        .content-shadow {
            padding: 20px; /* Menambahkan jarak di dalam container */
            background-color: #fff; /* Menetapkan latar belakang putih jika diperlukan */
            border-radius: 5px; /* Menambahkan sudut melengkung pada container */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Efek bayangan untuk keseluruhan konten */
        }

        .breadcrumbs-box-shadow {
            margin-bottom: 20px; /* Memberikan jarak antara breadcrumbs dan konten lainnya */
            background-color: #fff; /* Menetapkan latar belakang putih jika diperlukan */
            border-radius: 5px; /* Menambahkan sudut melengkung pada container breadcrumbs */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Efek bayangan untuk breadcrumbs */
        }

        .notification-button {
            position: relative;
            display: inline-block;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 5px 10px;
            border-radius: 50%;
            background: red;
            color: white;
        }
        .notification-dropdown {
    position: absolute;
    right: 10px;
    top: 60px; /* Sesuaikan dengan posisi tombol notifikasi */
    min-width: 300px;
    max-width: 400px;
    max-height: 500px;
    overflow-y: auto;
    background-color: white;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1051;
    padding: 15px;
    border-radius: 5px;
}
        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .dropdown-footer {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="<?= Yii::getAlias('@web') ?>/img/Lancetrack_ambulance.png" alt="Profile Picture">
    </div>
    <?php
    $menuItems = [
        [
            'label' => '<i class="fas fa-tachometer-alt"></i><span> Dashboard</span>',
            'url' => ['/site/dashboard']
        ],
        [
            'label' => '<i class="fas fa-ambulance"></i><span> Ambulance</span>',
            'url' => ['/ambulance/index']
        ],
        [
            'label' => '<i class="fas fa-map-marker-alt"></i><span> Ambulance Tracking</span>',
            'url' => ['/ambulance-location/view-location']
        ],
        [
            'label' => '<i class="fas fa-wrench"></i><span> Ambulance Maintenance</span>',
            'url' => ['/ambulancemaintenance/index']
        ],
        [
            'label' => '<i class="fas fa-shopping-cart"></i><span> Order</span>',
            'url' => ['/orders/index']
        ],
        [
            'label' => '<i class="fas fa-user"></i><span> Driver</span>',
            'url' => ['/drivers/index'] // Ganti dari ['/ambulanceorder/index'] ke ['/orders/index']
        ],
    ];

    echo Nav::widget([
        'options' => ['class' => 'nav flex-column'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    ?>
</div>

</div>

<header>
<!-- Navbar -->
<?php
use frontend\models\Notification; // Tambahkan ini

NavBar::begin([
    'options' => [
        'class' => 'navbar navbar-expand-md navbar-dark bg-success fixed-top navbar-fixed-top shadow p-3 mb-5',
    ],
]);

if (Yii::$app->user->isGuest) {
    echo Html::tag('div', Html::a('Login', ['/site/login'], ['class' => 'btn btn-link login text-decoration-none']), ['class' => 'd-flex ms-auto']);
} else {
    $notifications = Notification::find()->where([ 'is_read' => 0])->all();
    $newNotificationsCount = count($notifications);

    $notificationButton = Html::button(
        '<i class="fa fa-bell"></i> <span id="notification-count" class="badge badge-light bg-danger">' . $newNotificationsCount . '</span>',
        [
            'class' => 'btn btn-link text-decoration-none',
            'id' => 'notification-button',
            'style' => 'color: white;',
            'onclick' => 'toggleDropdown()'
        ]
    );

    $accountLink = Html::a('Lihat Akun', ['/site/account'], ['class' => 'btn btn-link text-decoration-none', 'style' => 'color: white;']);

    echo Html::tag('div', 
        Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
            . $notificationButton
            . $accountLink
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                [
                    'class' => 'btn btn-link logout text-decoration-none',
                    'style' => 'color: white; background-color: badge badge-success;',
                ]
            )
            . Html::endForm(),
        ['class' => 'd-flex ms-auto']
    );
}

NavBar::end();
?>
<!-- Notifikasi Dropdown -->
<div class="notification-dropdown" id="notification-dropdown" style="display: none;">
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $notification): ?>
            <div class="notification-item <?= $notification->is_read ? 'read' : 'unread' ?>">
                <?= Html::encode($notification->message) ?>
                <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($notification->created_at) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="notification-item">
            Tidak ada notifikasi.
        </div>
    <?php endif; ?>
</div>

<?=Alert::widget() ?>
<?= $notificationButton ?>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Polling notifikasi setiap 5 detik
    setInterval(function() {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/notification/check-new']) ?>',
            type: 'GET',
            success: function(data) {
                const newNotificationsCount = data.newNotificationsCount;
                if (newNotificationsCount > 0) {
                    $('#notification-count').text(newNotificationsCount).show();
                } else {
                    $('#notification-count').hide();
                }
            },
            error: function() {
                console.log('Error fetching notifications.');
            }
        });
    }, 5000);

    // Menangani klik pada ikon notifikasi
    $('#notification-button').on('click', function(e) {
        e.preventDefault();
        $('#notification-dropdown').toggle();

        // Load notifications via AJAX
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/notification/index']) ?>',
            type: 'GET',
            success: function(data) {
                $('#notification-dropdown').html(data);
            },
            error: function() {
                console.log('Error loading notifications.');
            }
        });
    });

    // Menutup dropdown ketika klik di luar
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#notification-button').length && !$(event.target).closest('#notification-dropdown').length) {
            $('#notification-dropdown').hide();
        }
    });
});
</script>

<!-- Konten Utama -->
<main role="main" class="flex-shrink-0 main-content">
    <div class="container">
        <!-- Kode yang sudah ada -->
        <div class="content-shadow">
            <div class="breadcrumbs-box-shadow">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
            <?= $content ?>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; My Company <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>