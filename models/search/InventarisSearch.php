<?php

namespace app\models\search;

use app\models\Inventaris;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

/**
 * InventarisSearch represents the model behind the search form about `app\models\Inventaris`.
 */
class InventarisSearch extends Inventaris
{


   /**
    * @inheritdoc
    */
   public function rules(): array
   {
      return [
         [['id', 'material_requisition_detail_penawaran_id', 'location_id'], 'integer'],
         [['kode_inventaris'], 'safe'],
         # [['quantity'], 'number'],
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

      $subQuery = (new Query())
         ->select([
            'inventaris_id' => 'ilpd.inventaris_id',
            'detail_id' => new Expression("MAX(ilpd.id) "),
            'master_id' => new Expression("MAX(ilpd.inventaris_laporan_perbaikan_master_id)"),
         ])
         ->from(['ilpd' => 'inventaris_laporan_perbaikan_detail'])
         ->groupBy('ilpd.inventaris_id');

      $query = Inventaris::find()
         ->select([
            'inventaris.*',
            'lastOrder' => 'ilpm.tanggal',
            'lastRepaired' => 'ilpd2.last_repaired',
            'lastRemarks' => 'ilpd2.remarks',
            'description' => 'b.nama',
            'merk' => 'b.merk_part_number',
            'namaSatuan' => 's.nama',
            'kondisi' => new Expression(" UPPER(s2.key) "),
            'lastLocation' => new Expression("COALESCE(c.nama, c2.nama)"),
         ])
         ->leftJoin(['c2' => 'card'], 'c2.id = inventaris.location_id')
         ->leftJoin(['m' => $subQuery], ' m.inventaris_id = inventaris.id')
         ->leftJoin(['ilpd2' => 'inventaris_laporan_perbaikan_detail'], 'm.detail_id = ilpd2.id')
         ->leftJoin(['c' => 'card'], 'ilpd2.last_location_id = c.id')
         ->leftJoin(['s2' => 'status'], 'ilpd2.kondisi_id = s2.id')
         ->leftJoin(['ilpm' => 'inventaris_laporan_perbaikan_master'], 'm.master_id = ilpm.id')
         ->leftJoin(['mrdp' => 'material_requisition_detail_penawaran'], 'inventaris.material_requisition_detail_penawaran_id = mrdp.id')
         ->leftJoin(['mrd' => 'material_requisition_detail'], ' mrdp.material_requisition_detail_id = mrd.id')
         ->leftJoin(['b' => 'barang'], ' mrd.barang_id = b.id')
         ->leftJoin(['po' => 'purchase_order'], 'mrdp.purchase_order_id = po.id')
         ->leftJoin(['s' => 'satuan'], 'mrd.satuan_id = s.id');

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
         'material_requisition_detail_penawaran_id' => $this->material_requisition_detail_penawaran_id,
         'location_id' => $this->location_id,
         'quantity' => $this->quantity,
      ]);

      $query->andFilterWhere(['like', 'kode_inventaris', $this->kode_inventaris]);

      return $dataProvider;
   }
}