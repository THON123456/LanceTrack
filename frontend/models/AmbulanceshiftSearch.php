<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Ambulanceshift;

/**
 * AmbulanceshiftSearch represents the model behind the search form of `app\models\Ambulanceshift`.
 */
class AmbulanceshiftSearch extends Ambulanceshift
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'waktu_shift_terakhir', 'biodata_id'], 'integer'],
            [['nama_shift'], 'safe'],
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
        $query = Ambulanceshift::find();

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
            'id' => $this->id,
            'waktu_shift_terakhir' => $this->waktu_shift_terakhir,
            'biodata_id' => $this->biodata_id,
        ]);

        $query->andFilterWhere(['like', 'nama_shift', $this->nama_shift]);

        return $dataProvider;
    }
}
