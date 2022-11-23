<?php

namespace app\models\search;

use app\models\Rekening;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * RekeningSearch represents the model behind the search form about `app\models\Rekening`.
 */
class RekeningSearch extends Rekening
{


    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'created_at', 'updated_at', 'card_id'], 'integer'],
            [['atas_nama', 'created_by', 'updated_by', 'cardNama'], 'safe'],
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
        $query = Rekening::find()
            ->select([
                'id' => 'rekening.id',
                'card_id' => 'card.id',
                'cardNama' => 'card.nama',
                'atas_nama' => 'rekening.atas_nama',
                'nomorNomorRekeningBank' => new Expression("
                     JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'bank', rekening_detail.bank,
                            'nomor_rekening',rekening_detail.nomor_rekening
                        )
                    )
                ")
            ])
            ->joinWith('card', false)
            ->joinWith('rekeningDetails', false)
            ->groupBy('rekening.id');

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'atas_nama', $this->atas_nama])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}