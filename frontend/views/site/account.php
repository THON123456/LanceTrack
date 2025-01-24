<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = 'Akun Saya';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-account">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <td><?= Html::encode($user->username) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= Html::encode($user->email) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= Html::encode($user->status == \common\models\User::STATUS_ACTIVE ? 'Active' : 'Inactive') ?></td>
        </tr>
        </tr>
    </table>
</div>
