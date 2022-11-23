<?php

namespace app\models\search;

use app\models\Quotation;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * QuotationSearch represents the model behind the search form about `app\models\Quotation`.
 */
class QuotationSearch extends Quotation
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'mata_uang_id', 'customer_id'], 'integer'],
            [['nomor', 'tanggal', 'tanggal_batas_valid', 'attendant_1', 'attendant_phone_1', 'attendant_email_1', 'attendant_2', 'attendant_phone_2', 'attendant_email_2', 'catatan_quotation_barang'], 'safe'],
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
        $query = Quotation::find();

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
            'mata_uang_id' => $this->mata_uang_id,
            'tanggal' => $this->tanggal,
            'customer_id' => $this->customer_id,
            'tanggal_batas_valid' => $this->tanggal_batas_valid,
        ]);

        $query->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'attendant_1', $this->attendant_1])
            ->andFilterWhere(['like', 'attendant_phone_1', $this->attendant_phone_1])
            ->andFilterWhere(['like', 'attendant_email_1', $this->attendant_email_1])
            ->andFilterWhere(['like', 'attendant_2', $this->attendant_2])
            ->andFilterWhere(['like', 'attendant_phone_2', $this->attendant_phone_2])
            ->andFilterWhere(['like', 'attendant_email_2', $this->attendant_email_2])
            ->andFilterWhere(['like', 'catatan_quotation_barang', $this->catatan_quotation_barang]);

        return $dataProvider;
    }
}