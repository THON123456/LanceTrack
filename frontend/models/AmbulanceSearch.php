<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Ambulance;

/**
 * AmbulanceSearch represents the model behind the search form of `frontend\models\Ambulance`.
 */
class AmbulanceSearch extends Ambulance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ambulance','status', 'latitude'], 'integer'],
            [['tipe', 'plat_nomor', 'nama', 'foto', 'created_at', 'updated_at', 'img_url'], 'safe'],
            [['longitude'], 'number'],
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
        $query = Ambulance::find();

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
            'id_ambulance' => $this->id_ambulance,  
            'status' => $this->status,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'tipe', $this->tipe])
            ->andFilterWhere(['like', 'plat_nomor', $this->plat_nomor])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'img_url', $this->img_url]);

        return $dataProvider;
    }
}
