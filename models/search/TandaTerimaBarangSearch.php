<?php

namespace app\models\search;

use app\models\TandaTerimaBarang;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TandaTerimaBarangSearch represents the model behind the search form about `app\models\TandaTerimaBarang`.
 */
class TandaTerimaBarangSearch extends TandaTerimaBarang
{

    public ?string $nomorPurchaseOrder = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'acknowledge_by_id', 'created_at', 'updated_at'], 'integer'],
            [['nomor', 'tanggal', 'catatan', 'received_by', 'messenger', 'created_by', 'updated_by', 'nomorPurchaseOrder'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = TandaTerimaBarang::find()
            ->joinWith('purchaseOrder');

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
            'acknowledge_by_id' => $this->acknowledge_by_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'received_by', $this->received_by])
            ->andFilterWhere(['like', 'messenger', $this->messenger])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'purchase_order.nomor', $this->nomorPurchaseOrder]);

        return $dataProvider;
    }
}