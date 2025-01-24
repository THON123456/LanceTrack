<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "ambulance".
 *
 * @property int $id_ambulance
 * @property string $tipe
 * @property string $plat_nomor
 * @property string $nama
 * @property int $id_ulasan
 * @property int $status
 * @property int|null $latitude
 * @property float|null $longitude
 * @property string $foto
 * @property string $created_at
 * @property string $updated_at
 * @property string $img_url
 */
class Ambulance extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $fotoFile;

    public static function tableName()
    {
        return 'ambulance';
    }

    public function rules()
    {
        return [
            [['tipe', 'plat_nomor', 'nama', 'id_ulasan', 'status'], 'required'],
            [['status', 'latitude'], 'integer'],
            [['longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['img_url'], 'string'],
            [['tipe', 'plat_nomor', 'nama'], 'string', 'max' => 100],
            [['foto'], 'string', 'max' => 255],
            [['fotoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = 'upload/img/' . $this->fotoFile->baseName . '.' . $this->fotoFile->extension;
            if ($this->fotoFile->saveAs(Yii::getAlias('@webroot') . '/' . $path)) {
                $this->foto = $path;
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ambulance' => 'ID Ambulance',
            'tipe' => 'Tipe',
            'plat_nomor' => 'Plat Nomor',
            'nama' => 'Nama',
            'status' => 'Status',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'foto' => 'Foto',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'img_url' => 'Img Url',
        ];
    }

    /**
     * Gets related Reviews model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['id' => 'id_ulasan']);
    }

    /**
     * Calculates the average rating from related Reviews.
     *
     * @return float
     */
    public function getAverageRating()
{
    $reviews = $this->getReviews()->all(); // Fetch all related reviews
    $totalRating = 0;
    $count = count($reviews);

    if ($count > 0) {
        foreach ($reviews as $review) {
            $totalRating += $review->rating_ambulans; // Use the correct field for ratings
        }
        return $totalRating / $count; // Return the average rating
    }

    return 0; // Return 0 if there are no reviews
}

public function getOrders()
{
    return $this->hasMany(Orders::class, ['id_ambulans' => 'id_ambulance']);
}

public function getUsers()
{
    return $this->hasOne(Users::class, ['id' => 'id_pemesan']); // Asumsikan `user_id` adalah foreign key di tabel `reviews`
}


}
