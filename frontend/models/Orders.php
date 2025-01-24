<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property string $kode_order
 * @property int|null $id_pemesan
 * @property int|null $id_ambulans
 * @property int|null $id_sopir
 * @property float|null $lat_tujuan
 * @property float|null $lon_tujuan
 * @property string $status
 * @property string|null $alasan
 * @property string $waktu_order
 * @property string|null $kondisi
 * @property string $reviewed
 */
class Orders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_order', 'status', 'reviewed'], 'required'],
            [['id_pemesan', 'id_ambulans', 'id_sopir'], 'integer'],
            [['lat_tujuan', 'lon_tujuan'], 'number'],
            [['status', 'reviewed'], 'string'],
            [['waktu_order'], 'safe'],
            [['kode_order', 'alasan', 'kondisi'], 'string', 'max' => 255],
            [['kode_order'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_order' => 'Kode Order',
            'id_pemesan' => 'ID Pemesan',
            'id_ambulans' => 'ID Ambulans',
            'id_sopir' => 'ID Sopir',
            'lat_tujuan' => 'Latitude Tujuan',
            'lon_tujuan' => 'Longitude Tujuan',
            'status' => 'Status',
            'alasan' => 'Alasan',
            'waktu_order' => 'Waktu Order',
            'kondisi' => 'Kondisi',
            'reviewed' => 'Reviewed',
        ];
    }

    /**
     * Gets related Reviews model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['kode_order' => 'kode_order']);
    }

    /**
     * Calculates the average rating from related Reviews.
     *
     * @return float
     */
    public function getAverageRating()
    {
        $reviews = $this->getReviews()->all();
        $totalRating = 0;
        $count = count($reviews);

        if ($count > 0) {
            foreach ($reviews as $review) {
                $totalRating += $review->rating_ambulans; // Adjust based on your rating field
            }
            return $totalRating / $count;
        }

        return 0;
    }

    public function getAmbulance()
{
    return $this->hasOne(Ambulance::class, ['id_ambulance' => 'id_ambulans']);
}

    /**
     * Gets query for [[AmbulanceBooking]].
     *
     * @return \yii\db\ActiveQuery
     */

    /**
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery
     */

public function getDrivers()
{
    return $this->hasOne(Drivers::class, ['id' => 'id_sopir']);
}

public function getUsers()
{
    return $this->hasOne(Users::class, ['id' => 'id_pemesan']); // Asumsikan `user_id` adalah foreign key di tabel `reviews`
}
}
