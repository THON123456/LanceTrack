<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $notifications frontend\models\Notification[] */
?>

<?php if (!empty($notifications)): ?>
    <?php foreach ($notifications as $notification): ?>
        <div class="notification-item <?= $notification->is_read ? 'read' : 'unread' ?>">
            <?= Html::a(Html::encode($notification->message), $notification->url) ?>
            <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($notification->created_at) ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="notification-item">
        Tidak ada notifikasi.
    </div>
<?php endif; ?>
