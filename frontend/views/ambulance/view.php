<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Ambulance $model */

$this->title = $model->id_ambulance;
$this->params['breadcrumbs'][] = ['label' => 'Ambulances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ambulance-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_ambulance',
            'tipe',
            'plat_nomor',
            'nama',
            // Jika id_ulasan bukan field yang valid, hapus atau sesuaikan ini:
            // 'id_ulasan',
            'status',
            'latitude',
            'longitude',
            [
                'attribute' => 'foto',
                'format' => ['image', ['width' => '100', 'height' => '100']], // Menampilkan foto jika ada
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'img_url',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a('Lihat Gambar', $model->img_url, ['target' => '_blank']);
                },
            ],
        ],
    ]) ?>

    <div class="reviews-section">
        <h3>Average Rating</h3>
        <p><?= number_format($model->getAverageRating(), 2) ?> / 5</p>
        
        <?php if ($model->getReviews()->count() > 0): ?>
            <?= Html::a('Lihat Review', ['view-reviews', 'id' => $model->id_ambulance], ['class' => 'btn btn-primary']) ?>
        <?php else: ?>
            <p>Data tidak tersedia.</p>
        <?php endif; ?>
    </div>

</div>
