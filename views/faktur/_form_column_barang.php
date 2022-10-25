<?php

use app\models\Barang;
use app\models\FakturDetail;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var $form ActiveForm*/
/** @var $modelDetail FakturDetail*/
/** @var $i integer*/

$urlAvailableVendor = Url::to(['barang/find-available-vendor']);
$onChangeBarang = <<<JS

    var ini = jQuery(this);
    var barangId = ini.val();
    
    if(barangId){
        
        var row = ini.closest('tr');
        row.find('.quantity').val('1.00');
        
        var vendorId = row.find('.vendor-id');
        var satuanId = row.find('.satuan-id');
        var hargaBarang = row.find('.harga-barang');
        
        vendorId.empty();
        satuanId.empty();
        hargaBarang.val('');
        
        jQuery.post('$urlAvailableVendor', { barangId : barangId}, function(response){
           console.log(response);
           vendorId.append(new Option("= Select ... = ", '', false, false));
           jQuery.each(response.data, function(el, v){
               vendorId.append(new Option(v, el, false, false));
           });
           vendorId.trigger('change');
           vendorId.select2('open');
        });
    }
JS;
?>

<?php
try {
    echo $form->field($modelDetail, "[$i]barang_id", ['template' =>
        '{input}{error}{hint}', 'options' => ['class' => null]])
        ->widget(Select2::class, [
            'data' => Barang::find()->map(),
            'options' => [
                'prompt' => '= Pilih Salah Satu =',
                'class' => 'barang-id',
                'onchange' => "$onChangeBarang",
            ]
        ]);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>