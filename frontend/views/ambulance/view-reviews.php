<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Ambulance $ambulance */
/** @var frontend\models\Reviews[] $reviews */

$this->title = 'Reviews for ' . Html::encode($ambulance->nama);
$this->params['breadcrumbs'][] = ['label' => 'Ambulances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view-reviews">

    <h1><?= Html::encode($this->title) ?></h1>

<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="review-box">
            <h3>
                <!-- Ganti nama kolom sesuai dengan yang ada di model -->
                <?= Html::encode($review->id_pemesan) ?> <!-- Ganti dengan kolom yang relevan jika ada -->
                (<?= number_format($review->rating_ambulans, 2) ?> <i class="fas fa-star"></i>)
            </h3>
            <p><strong>Waktu:</strong> <?= Yii::$app->formatter->asDatetime($review->waktu, 'long') ?></p>
            <p><strong>Rating Sopir:</strong> <?= number_format($review->rating_sopir, 2) ?> <i class="fas fa-star"></i></p>
            <p><strong>Review Sopir:</strong> <?= Html::encode($review->review_sopir) ?></p>
            <p><strong>Review Ambulans:</strong> <?= Html::encode($review->review_ambulans) ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Tidak ada review untuk ditampilkan.</p>
<?php endif; ?>

</div>

<style>
.view-reviews {
    margin-top: 20px;
}

.review-box {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

.review-box h3 {
    margin-bottom: 5px;
    font-size: 18px;
}

.review-box p {
    margin-bottom: 10px;
}

.review-box i.fa-star {
    color: gold;
}
</style>
