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

try {
    $urlFindAvailableSatuan = Url::to(['/barang/find-available-satuan']);
    $data = [];

    if (!$model->isNewRecord) {
        $barangSatuan = BarangSatuan::find()
            ->select([
                'id' => 'vendor_id',
                'name' => 'card.nama'
            ])
            ->joinWith('vendor', false)
            ->where(['barang_id' => $modelDetail->barang_id])
            ->asArray()
            ->all();
        $data = ArrayHelper::map($barangSatuan, 'id', 'name');
    }

    $onChangeVendor = <<<JS
        var ini = jQuery(this);
        var vendorId = ini.val();
        
        if(vendorId){
            
            var row = ini.closest('tr');
            var barangId = row.find('.barang-id').val();
            var satuanId = row.find('.satuan-id');
            var hargaBarang = row.find('.harga-barang');
            
            satuanId.empty();
            hargaBarang.val('');
            
            jQuery.post('$urlFindAvailableSatuan', { barangId : barangId, vendorId : vendorId}, function(response){
               console.log(response);
               satuanId.append(new Option("= Select ... = ", '', false, false));
               jQuery.each(response.data, function(el, v){
                   satuanId.append(new Option(v, el, false, false));
               });
               satuanId.trigger('change');
               satuanId.select2('open');
            });
        }
                                        
JS;

    echo $form->field($modelDetail, "[$i]vendor_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
        ->widget(Select2::class, [
            'data' => $data,
            'options' => [
                'prompt' => '= Pilih Salah Satu =',
                'class' => 'vendor-id form-control',
                'onchange' => "$onChangeVendor",
            ]
        ]);
} catch (Exception $e) {
    echo $e->getMessage();
}