<?php


/* @var $this View */

/* @var $model MaterialRequisition|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\MaterialRequisition;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>

<div class="d-flex flex-column gap-2">

    <div class="d-flex flex-row gap-2">
        <h3>Penawaran Harga</h3>
        <div class="ms-auto">
            <?= Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print-penawaran-to-pdf', 'id' => $model->id], [
                'class'  => 'btn btn-outline-success',
                'target' => '_blank',
                'rel'    => 'noopener noreferrer'
            ]) ?>
        </div>
    </div>

    <?php Pjax::begin([
        'id'              => 'material-requisition-detail-penawaran-list-view',
        'timeout'         => 0,
        'enablePushState' => false,
    ]); ?>

    <?= ListView::widget([
        'id'           => 'material-requisition-detail-penawaran-list-view-list',
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getMaterialRequisitionDetails()
        ]),
        'itemView'     => function ($model, $key, $index, $widget) {
            /** @see views/material-requisition/_view_penawaran_harga_detail.php */
            return $this->render('_view_penawaran_harga_detail', [
                'model' => $model
            ]);
        },
        'options'      => [
            'class' => 'd-flex flex-column gap-3 '
        ]
    ]); ?>

    <?php Pjax::end(); ?>


    <?php
    Modal::begin([
        'id'           => 'modal-penawaran-harga',
        'size'         => Modal::SIZE_EXTRA_LARGE,
        'titleOptions' => [
            'id' => 'modal-penawaran-harga-title'
        ],
        'title'        => 'Sedang memuat halaman ...',
        'bodyOptions'  => [
            'id' => 'modal-penawaran-harga-body'
        ],
        'options'      => [
            'data-bs-backdrop' => 'static',
            'data-bs-keyboard' => 'false',
        ],
        'footer'       => '<div class="me-auto"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> </div> <div id="modal-penawaran-harga-footer"> </div>'
    ]); ?>


    <?php Modal::end(); ?>

    <?php
    $js = <<<JS
    
    const ajaxModal = document.getElementById('modal-penawaran-harga');
    const ajaxModalTitle = document.getElementById('modal-penawaran-harga-title');
    const ajaxModalBody = document.getElementById('modal-penawaran-harga-body');
    const ajaxModalFooter = document.getElementById('modal-penawaran-harga-footer');
    
    /* By default, the modal is hidden, so we need to show it manually */
    ajaxModal.addEventListener('shown.bs.modal', event => {
        
        /* use GET to fetch the content*/
      jQuery.get(jQuery(event.relatedTarget).attr('href'), function(response){
        jQuery('#modal-penawaran-harga-title').html(response.title);
        jQuery('#modal-penawaran-harga-body').html(response.content);   // jQuery akan mengeksekusi <script>
        jQuery('#modal-penawaran-harga-footer').html(response.footer);
        
        
         //  We need to handle the form submission manually
          jQuery('#modal-penawaran-harga-body form').on('beforeSubmit', function(event){
                
                var \$form = jQuery(this);
    
                jQuery.ajax({
                    url: \$form.attr('action'),
                    type: 'POST',
                    data: \$form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.forceClose === true) {
                            const modal = bootstrap.Modal.getInstance(ajaxModal) || new bootstrap.Modal(ajaxModal);
                            modal.hide();
                            jQuery.pjax.reload({container: '#material-requisition-detail-penawaran-list-view'}); 
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan sistem.');
                    }
                });
                return false;
          })
      
      });
      
      
     
            
    });
    
    // When the modal is hidden, we need to reset the content
    ajaxModal.addEventListener('hidden.bs.modal', () => {
      ajaxModalTitle.innerHTML = 'Sedang memuat halaman ...';
      ajaxModalBody.innerHTML= '';
      ajaxModalFooter.innerHTML= '';
    });
    
    JS;

    $this->registerJs($js);
    ?>
</div>