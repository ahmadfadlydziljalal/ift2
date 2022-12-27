<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistoryLokasiBarang;

/**
 * HistoryLokasiBarangSearch represents the model behind the search form about `app\models\HistoryLokasiBarang`.
 */
class HistoryLokasiBarangSearch extends HistoryLokasiBarang
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'card_id', 'tanda_terima_barang_detail_id', 'claim_petty_cash_nota_detail_id', 'quotation_delivery_receipt_detail_id', 'tipe_pergerakan_id', 'step', 'depend_id'], 'integer'],
            [['nomor', 'block', 'rak', 'tier', 'row', 'catatan'], 'safe'],
            [['quantity'], 'number'],
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
        $query = HistoryLokasiBarang::find();

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
            'tanda_terima_barang_detail_id' => $this->tanda_terima_barang_detail_id,
            'claim_petty_cash_nota_detail_id' => $this->claim_petty_cash_nota_detail_id,
            'quotation_delivery_receipt_detail_id' => $this->quotation_delivery_receipt_detail_id,
            'tipe_pergerakan_id' => $this->tipe_pergerakan_id,
            'step' => $this->step,
            'quantity' => $this->quantity,
            'depend_id' => $this->depend_id,
        ]);

        $query->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'block', $this->block])
            ->andFilterWhere(['like', 'rak', $this->rak])
            ->andFilterWhere(['like', 'tier', $this->tier])
            ->andFilterWhere(['like', 'row', $this->row])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}