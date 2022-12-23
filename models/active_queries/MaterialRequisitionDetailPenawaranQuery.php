<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\enums\TipePembelianEnum;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\Status;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\app\models\MaterialRequisitionDetailPenawaran]].
 *
 * @see MaterialRequisitionDetailPenawaran
 */
class MaterialRequisitionDetailPenawaranQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/


   /**
    * @inheritdoc
    * @return MaterialRequisitionDetailPenawaran|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }

   /**
    * @param array $materialRequestAndVendorId
    * @return array
    */
   public function forCreateAction(array $materialRequestAndVendorId): array
   {
      return parent::joinWith('materialRequisitionDetail', false)
         ->joinWith('status')
         ->where([
            'material_requisition_id' => $materialRequestAndVendorId['material_requisition_id'],
            'material_requisition_detail_penawaran.vendor_id' => $materialRequestAndVendorId['vendor_id'],
            'status.section' => 'material-requisition-detail-penawaran-status',
            'status.key' => 'Diterima',

         ])
         ->andWhere([
            'IS', 'material_requisition_detail_penawaran.purchase_order_id', NULL
         ])
         ->all();
   }

   /**
    * @inheritdoc
    * @return MaterialRequisitionDetailPenawaran[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }

   public function forCreateTandaTerima($purchaseOrderId): array
   {
      $parent = parent::select('material_requisition_detail_penawaran.*')
         ->addSelect([
            'totalQuantitySudahDiterima' => new Expression("SUM(COALESCE(ttbd.quantity_terima, 0))")
         ])
         ->joinWith(['tandaTerimaBarangDetails' => function ($ttbd) {
            $ttbd->alias('ttbd');
         }])
         ->where([
            'purchase_order_id' => $purchaseOrderId
         ])
         ->groupBy('material_requisition_detail_penawaran.id, material_requisition_detail_penawaran.quantity_pesan')
         ->having('material_requisition_detail_penawaran.quantity_pesan != totalQuantitySudahDiterima');

      return $parent->all();

   }

   public function forInventaris(): array
   {
      $status = Status::findOne([
         'section' => 'material-requisition-detail-penawaran-status',
         'key' => 'Diterima',
      ]);

      $parent = parent::select([
         'id' => 'material_requisition_detail_penawaran.id',
         'namaBarang' => 'barang.nama',
         'namaSatuan' => 'satuan.nama',
         'namaVendor' => 'vendor.nama',
         'nomorPurchaseOrder' => 'purchase_order.nomor',
         'quantity_pesan' => 'material_requisition_detail_penawaran.quantity_pesan',
         'quantityInventaris' => new Expression("COALESCE(SUM(inventaris.quantity), 0)"),
         'quantityMrdpBelumMasukDiInventaris' => new Expression("material_requisition_detail_penawaran.quantity_pesan - (COALESCE(SUM(inventaris.quantity), 0))"),
      ])
         ->joinWith(['vendor' => function ($vendor) {
            return $vendor->alias('vendor');
         }], false)
         ->joinWith(['status' => function ($s) {
            return $s->alias('s');
         }], false)
         ->joinWith(['materialRequisitionDetail' => function ($mrd) {
            return $mrd
               ->joinWith('barang')
               ->joinWith('satuan');
         }], false)
         ->joinWith('purchaseOrder', false)
         ->joinWith('inventaris', false)
         ->where([
            'barang.tipe_pembelian_id' => TipePembelianEnum::INVENTARIS->value
         ])
         ->andWhere([
            'material_requisition_detail_penawaran.status_id' => $status->id
         ])
         ->andWhere([
            'IS NOT', 'purchase_order.id', NULL
         ])
         ->groupBy('material_requisition_detail_penawaran.id')
         ->having('quantityMrdpBelumMasukDiInventaris > 0')
         ->all();

      /*die(
      Html::tag('pre', VarDumper::dumpAsString($parent))
      );*/

      return ArrayHelper::map($parent, 'id', function ($model) {
         return $model->namaBarang
            . ' - ' . $model->namaVendor
            . ' - ' . $model->nomorPurchaseOrder

            . ' - Belum masuk: ' . $model->quantityMrdpBelumMasukDiInventaris
            . ' ' . $model->namaSatuan;
      });


   }

   public function map(): array
   {
      $data = parent::select([
         'id' => 'mrdp.id',
         'asOptionList' => 'CONCAT(po.nomor, " ", mrdp.quantity_pesan, " ",  satuan.nama)'
      ])
         ->alias('mrdp')
         ->joinWith(['materialRequisitionDetail' => function ($mrd) {
            $mrd->alias('mrd')
               ->joinWith('satuan');
         }])
         ->joinWith(['purchaseOrder' => function ($po) {
            $po->alias('po');
         }])
         ->where([
            'IS NOT', 'mrdp.purchase_order_id', NULL
         ])
         ->all();

      return ArrayHelper::map($data, 'id', 'asOptionList');
   }
}