<?php
namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch represents the model behind the search form of `frontend\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_order', 'status', 'alasan', 'waktu_order', 'kondisi', 'reviewed'], 'safe'],
            [['id_pemesan', 'id_ambulans', 'id_sopir'], 'integer'],
            [['lat_tujuan', 'lon_tujuan'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pemesan' => $this->id_pemesan,
            'id_ambulans' => $this->id_ambulans,
            'id_sopir' => $this->id_sopir,
            'lat_tujuan' => $this->lat_tujuan,
            'lon_tujuan' => $this->lon_tujuan,
            'waktu_order' => $this->waktu_order,
        ]);

        $query->andFilterWhere(['like', 'kode_order', $this->kode_order])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'alasan', $this->alasan])
            ->andFilterWhere(['like', 'kondisi', $this->kondisi])
            ->andFilterWhere(['like', 'reviewed', $this->reviewed]);

        return $dataProvider;
    }
}
