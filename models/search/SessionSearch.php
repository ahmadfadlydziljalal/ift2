<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Session;

/**
 * SessionSearch represents the model behind the search form about `app\models\Session`.
 */
class SessionSearch extends Session
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'data'], 'safe'],
            [['expire', 'user_id', 'last_write'], 'integer'],
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
        $query = Session::find();

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
            'expire' => $this->expire,
            'user_id' => $this->user_id,
            'last_write' => $this->last_write,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}