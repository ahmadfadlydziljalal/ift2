<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CardPersonInCharge;

/**
 * CardPersonInChargeSearch represents the model behind the search form about `app\models\CardPersonInCharge`.
 */
class CardPersonInChargeSearch extends CardPersonInCharge
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'card_id'], 'integer'],
            [['nama', 'telepon', 'email'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() : array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params) : ActiveDataProvider
    {
        $query = CardPersonInCharge::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'card_id' => $this->card_id,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'telepon', $this->telepon])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}