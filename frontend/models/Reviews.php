<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $kode_order
 * @property int $id_pemesan
 * @property int $id_ambulans
 * @property float $rating_ambulans
 * @property string|null $review_ambulans
 * @property int $id_sopir
 * @property float $rating_sopir
 * @property string|null $review_sopir
 * @property string $waktu
 */
class Reviews extends ActiveRecord
{
    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['kode_order', 'id_pemesan', 'id_ambulans', 'rating_ambulans', 'id_sopir', 'rating_sopir'], 'required'],
            [['id_pemesan', 'id_ambulans', 'id_sopir'], 'integer'],
            [['rating_ambulans', 'rating_sopir'], 'number'],
            [['review_ambulans', 'review_sopir'], 'string'],
            [['waktu'], 'safe'],
            [['kode_order'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_order' => 'Kode Order',
            'id_pemesan' => 'Id Pemesan',
            'id_ambulans' => 'Id Ambulans',
            'rating_ambulans' => 'Rating Ambulans',
            'review_ambulans' => 'Review Ambulans',
            'id_sopir' => 'Id Sopir',
            'rating_sopir' => 'Rating Sopir',
            'review_sopir' => 'Review Sopir',
            'waktu' => 'Waktu',
        ];
    }
    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['kode_order' => 'kode_order']);
    }

    public function getAverageRating()
{
    $reviews = $this->getReviews()->all();
    $totalRating = 0;
    $count = count($reviews);

    if ($count > 0) {
        foreach ($reviews as $review) {
            $totalRating += $review->rating; // Sesuaikan dengan nama kolom rating yang benar
        }
        return $totalRating / $count;
    }

    return 0;
}
}
