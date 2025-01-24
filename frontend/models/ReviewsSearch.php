<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Reviews;

/**
 * ReviewsSearch represents the model behind the search form of `app\models\Reviews`.
 */
class ReviewsSearch extends Reviews
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_pemesan', 'id_ambulans', 'id_sopir'], 'integer'],
            [['kode_order', 'review_ambulans', 'review_sopir', 'waktu'], 'safe'],
            [['rating_ambulans', 'rating_sopir'], 'number'],
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
        $query = Reviews::find();

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
            'id_pemesan' => $this->id_pemesan,
            'id_ambulans' => $this->id_ambulans,
            'rating_ambulans' => $this->rating_ambulans,
            'id_sopir' => $this->id_sopir,
            'rating_sopir' => $this->rating_sopir,
            'waktu' => $this->waktu,
        ]);

        $query->andFilterWhere(['like', 'kode_order', $this->kode_order])
            ->andFilterWhere(['like', 'review_ambulans', $this->review_ambulans])
            ->andFilterWhere(['like', 'review_sopir', $this->review_sopir]);

        return $dataProvider;
    }
}
