<?php

namespace app\models\search;

use app\models\MaterialRequisition;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MaterialRequisitionSearch represents the model behind the search form about `app\models\MaterialRequisition`.
 */
class MaterialRequisitionSearch extends MaterialRequisition
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'vendor_id', 'created_at', 'updated_at'], 'integer'],
            [['nomor', 'tanggal', 'remarks', 'approved_by_id', 'acknowledge_by_id', 'created_by', 'updated_by'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = MaterialRequisition::find();

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
            'vendor_id' => $this->vendor_id,
            'tanggal' => $this->tanggal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'approved_by_id', $this->approved_by_id])
            ->andFilterWhere(['like', 'acknowledge_by_id', $this->acknowledge_by_id])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}