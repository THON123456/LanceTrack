<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Ambulanceulasan;

/**
 * AmbulanceulasanSearch represents the model behind the search form of `app\models\Ambulanceulasan`.
 */
class AmbulanceulasanSearch extends Ambulanceulasan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ulasan', 'user_id', 'rating', 'created_at'], 'integer'],
            [['review'], 'safe'],
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
        $query = Ambulanceulasan::find();

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
            'id_ulasan' => $this->id_ulasan,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'review', $this->review]);

        return $dataProvider;
    }
}
