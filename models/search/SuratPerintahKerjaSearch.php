<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SuratPerintahKerja;

/**
 * SuratPerintahKerjaSearch represents the model behind the search form about `app\models\SuratPerintahKerja`.
 */
class SuratPerintahKerjaSearch extends SuratPerintahKerja
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id'], 'integer'],
            [['nomor', 'tanggal', 'pelaksana', 'keterangan', 'data_pendukung_lainnya'], 'safe'],
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
        $query = SuratPerintahKerja::find();

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
            'tanggal' => $this->tanggal,
        ]);

        $query->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'pelaksana', $this->pelaksana])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'data_pendukung_lainnya', $this->data_pendukung_lainnya]);

        return $dataProvider;
    }
}