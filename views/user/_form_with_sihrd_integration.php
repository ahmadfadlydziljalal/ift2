<?php


/* @var $this View */

/* @var $model User|ActiveRecord */

/* @var $response array | null */

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

?>

    <div class="user-form">
        <p>Untuk mengambil data dari user dari SIHRD, pastikan nama karyawan sudah <strong
                    class="text-danger">exist</strong>
            pada SIHRD
        </p>

        <div class="row">
            <div class="col-12 col-lg-8">

                <div class="form-group">
                    <label for="nama-karyawan" class="form-label">Karyawan</label>
                    <div class="input-group">

                        <span class="input-group-text" id="api-karyawan-url"
                              data-url="<?= Yii::$app->params['hrdUrl'] . '/api/karyawans' ?>">
                            <?= Yii::$app->params['hrdUrl'] . '/api/karyawans' ?>
                        </span>

                        <input autofocus
                               placeholder="Nama Karyawan"
                               type="text"
                               class="form-control"
                               id="nama-karyawan"
                               aria-describedby="api-karyawan-url"
                               value="<?php
                               if (!$model->isNewRecord) {
                                   echo $response['nama_karyawan'];
                               }
                               ?>"
                        >

                        <button class="btn btn-outline-primary"
                                type="button"
                                id="button-search-karyawan"
                        >
                            Search
                        </button>
                    </div>
                </div>

                <div class="d-flex flex-row flex-wrap px-0 py-3" style="gap: 1rem" id="api-karyawan-result">

                </div>



            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <?php $form = ActiveForm::begin([
                    'id' => 'user-form',
                    'layout' => ActiveForm::LAYOUT_FLOATING
                ]) ?>

                <?= $form->errorSummary($model) ?>

                Token: <strong><?php
                    $target = Yii::$app->params['superAdminUserToken'];
                    $count = strlen($target) - 7;
                    $output = substr_replace($target, str_repeat('*', $count), 4, $count);
                    echo $output;
                    ?></strong>

                <?= $form->field($model, 'nama_karyawan') ?>
                <?= $form->field($model, 'username') ?>

                <div class="d-none">
                    <?= $form->field($model, 'id') ?>
                    <?= $form->field($model, 'auth_key') ?>
                    <?= $form->field($model, 'password_hash') ?>
                    <?= $form->field($model, 'password_reset_token') ?>
                    <?= $form->field($model, 'created_at') ?>
                    <?= $form->field($model, 'updated_at') ?>
                    <?= $form->field($model, 'karyawan_id') ?>
                </div>

                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'status') ?>

                <div class="d-flex mt-3 justify-content-between">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
                            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                    ) ?>

                    <?= Html::a(' Tutup', ['index'], [
                        'class' => 'btn btn-secondary',
                        'data-confirm' => 'Anda akan meninggalkan halaman ini ?'
                    ]) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

<?php
$token = Yii::$app->params['superAdminUserToken'];

$js = <<<JS

jQuery(document).on("click", "#api-karyawan-result button", function() {
    let ini =  jQuery(this);
    let htmlText = ini.html();
    jQuery(this).html(htmlText + ' <i class="bi bi-check-lg"></i>');
    jQuery('#user-id').val(jQuery(this).data('id'));
    jQuery('#user-nama_karyawan').val(jQuery(this).data('nama_karyawan'));
    jQuery('#user-username').val(jQuery(this).data('username'));
    jQuery('#user-auth_key').val(jQuery(this).data('auth_key'));
    jQuery('#user-password_hash').val(jQuery(this).data('password_hash'));
    jQuery('#user-password_reset_token').val(jQuery(this).data('password_reset_token'));
    jQuery('#user-email').val(jQuery(this).data('email'));
    jQuery('#user-status').val(jQuery(this).data('status'));
    jQuery('#user-created_at').val(jQuery(this).data('created_at'));
    jQuery('#user-updated_at').val(jQuery(this).data('updated_at'));
    jQuery('#user-karyawan_id').val(jQuery(this).data('karyawan_id'));
    setTimeout(function(){
        ini.html(htmlText);
    }, 1000)
});

let token = `$token`
let apiUrlKaryawan = jQuery('#api-karyawan-url').data('url');
let apiUrlKaryawanParam = jQuery('#nama-karyawan');
let apiKaryawanResult = jQuery('#api-karyawan-result');
let buttonSearchKaryawan = jQuery('#button-search-karyawan');
let password = null;

buttonSearchKaryawan.click(function (){
    
    apiKaryawanResult.empty();
    buttonSearchKaryawan.prop('disabled', true).html('...Searching...');
    
    jQuery.ajax({
        type : 'GET',
        url : apiUrlKaryawan + '?filter[nama][like]=' + apiUrlKaryawanParam.val(),
        dataType : 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Basic " + btoa(token + ":" + password));
        },
        success: function(response) {
            $("#user-form").trigger('reset');
            let options = '';
            if(response.length > 0){
                for(let keyObject in response){
                    if(response[keyObject].user !== null){
                         options += 
                    '<button class="btn btn-outline-success" ' +
                            'data-id="'+response[keyObject].user.id+'"' + 
                            'data-username="'+response[keyObject].user.username+'"' + 
                            'data-auth_key="'+response[keyObject].user.auth_key+'"' + 
                            'data-password_hash="'+response[keyObject].user.password_hash+'"' + 
                            'data-password_reset_token="'+response[keyObject].user.password_reset_token+'"' + 
                            'data-email="'+response[keyObject].user.email+'"' + 
                            'data-status="'+response[keyObject].user.status+'"' + 
                            'data-created_at="'+response[keyObject].user.created_at+'"' + 
                            'data-updated_at="'+response[keyObject].user.updated_at+'"' + 
                            'data-nama_karyawan="'+response[keyObject].nama+'"' + 
                            'data-karyawan_id="'+response[keyObject].user.karyawan_id+'"> ' + 
                        response[keyObject].nama + 
                    ' </button>';
                    }
                }
            }
            
            apiKaryawanResult.append(options);
        },
        error : function(xhr, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(textStatus);
            console.log(xhr.status);
            buttonSearchKaryawan.html(textStatus + ' ' + xhr.status).removeClass('btn-outline-primary').addClass('btn-outline-danger');
        }
     })
    .done(function() {
        buttonSearchKaryawan.html('Found').removeClass('btn-outline-primary').addClass('btn-outline-success');
    })
    .fail(function() {
        $("#user-form").trigger('reset');
    })
    .always(function() {
       setTimeout(function(){
            buttonSearchKaryawan.html('Search').prop('disabled', false).removeClass('btn-outline-danger btn-outline-success').addClass('btn-outline-primary');
       }, 2000)
    });
});

JS;
$this->registerJs($js);