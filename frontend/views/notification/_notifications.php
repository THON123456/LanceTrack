<?php if (count($notifications) > 0): ?>
    <ul class="list-group">
        <?php foreach ($notifications as $notification): ?>
            <li class="list-group-item"><?= $notification['message'] ?> <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($notification['timestamp']) ?></small></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="text-center">No notifications found.</p>
<?php endif; ?>