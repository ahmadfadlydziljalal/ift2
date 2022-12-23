<?php

use yii\db\Migration;

/**
 * Class m221222_092805_CreateInventarisRelation
 */
class m221222_092805_CreateInventarisRelation extends Migration
{

   private string $tableInventaris = '{{%inventaris}}';
   private string $tableInventarisLaporanPerbaikanMaster = '{{%inventaris_laporan_perbaikan_master}}';
   private string $tableInventarisLaporanPerbaikanDetail = '{{%inventaris_laporan_perbaikan_detail}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {

      $this->addForeignKey(
         'fk_material_requisition_detail_penawaran_id_di_inventaris',
         $this->tableInventaris,
         'material_requisition_detail_penawaran_id',
         'material_requisition_detail_penawaran',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_card_location_di_inventaris',
         $this->tableInventaris,
         'location_id',
         'card',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_card_to_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanMaster,
         'card_id',
         'card',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_status_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanMaster,
         'status_id',
         'status',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_approved_by_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanMaster,
         'approved_by_id',
         'card',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_known_by_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanMaster,
         'known_by_id',
         'card',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_inventaris_laporan_perbaikan_master_id_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanDetail,
         'inventaris_laporan_perbaikan_master_id',
         'inventaris_laporan_perbaikan_master',
         'id',
         'CASCADE',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_inventaris_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanDetail,
         'inventaris_id',
         'inventaris',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_kondisi_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanDetail,
         'kondisi_id',
         'status',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_last_location_di_laporan_perbaikan',
         $this->tableInventarisLaporanPerbaikanDetail,
         'last_location_id',
         'card',
         'id',
         'RESTRICT',
         'CASCADE'
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey('fk_material_requisition_detail_penawaran_id_di_inventaris', $this->tableInventaris);
      $this->dropForeignKey('fk_card_location_di_inventaris', $this->tableInventaris);
      $this->dropForeignKey('fk_card_to_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster,);
      $this->dropForeignKey('fk_status_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster);
      $this->dropForeignKey('fk_approved_by_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster);
      $this->dropForeignKey('fk_known_by_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster);
      $this->dropForeignKey('fk_inventaris_laporan_perbaikan_master_id_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail);
      $this->dropForeignKey('fk_inventaris_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail);
      $this->dropForeignKey('fk_kondisi_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail);
      $this->dropForeignKey('fk_last_location_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail);
   }

}