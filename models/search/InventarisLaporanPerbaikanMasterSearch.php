<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InventarisLaporanPerbaikanMaster;

/**
 * InventarisLaporanPerbaikanMasterSearch represents the model behind the search form about `app\models\InventarisLaporanPerbaikanMaster`.
 */
class InventarisLaporanPerbaikanMasterSearch extends InventarisLaporanPerbaikanMaster
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'card_id', 'status_id', 'approved_by_id', 'known_by_id', 'created_at', 'updated_at'], 'integer'],
            [['nomor', 'tanggal', 'comment', 'created_by', 'updated_by'], 'safe'],
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
        $query = InventarisLaporanPerbaikanMaster::find();

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'card_id' => $this->card_id,
            'status_id' => $this->status_id,
            'approved_by_id' => $this->approved_by_id,
            'known_by_id' => $this->known_by_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}