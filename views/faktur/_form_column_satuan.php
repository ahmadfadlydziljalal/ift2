<?php

use app\components\helpers\ArrayHelper;
use app\models\BarangSatuan;
use app\models\Faktur;
use app\models\FakturDetail;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var $model Faktur  */
/** @var $modelDetail FakturDetail  */
/** @var $form  ActiveForm */
/** @var $i integer */

$urlHarga = Url::to(['/barang/find-available-harga']);
$data = [];

if (!$model->isNewRecord) {
    $barangSatuan = BarangSatuan::find()
        ->select([
            'id' => 'satuan_id',
            'name' => 'satuan.nama'
        ])
        ->joinWith('satuan', false)
        ->where(['barang_id' => $modelDetail->barang_id])
        ->asArray()
        ->all();
    $data = ArrayHelper::map($barangSatuan, 'id', 'name');
}

$js = <<<JS
    var ini = jQuery(this);
    var satuanId = ini.val();
    
    if(satuanId){
        var row = ini.closest('tr');
        var barangId = row.find('.barang-id').val(); 
        var vendorId = row.find('.vendor-id').val(); 
        var hargaBarang = row.find('.harga-barang');
        
        hargaBarang.val('');
        jQuery.post('$urlHarga', { barangId : barangId, satuanId : satuanId, vendorId : vendorId}, function(response){
            console.log(response);
            hargaBarang.val(response.data.harga_jual);
        });
    }
                                        
JS;

try {
    echo $form->field($modelDetail, "[$i]satuan_id", ['template' =>
        '{input}{error}{hint}', 'options' => ['class' => null]])
        ->widget(Select2::class, [
            'data' => $data,
            'options' => [
                'prompt' => '= Pilih Salah Satu =',
                'class' => 'satuan-id form-control',
                'onchange' => "$js",
            ]
        ]);

} catch (Exception $e) {
    echo $e->getMessage();
}