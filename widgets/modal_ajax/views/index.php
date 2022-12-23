<?php

/* @var $this View */

use yii\bootstrap5\Modal;
use yii\web\View;

Modal::begin([
   'id' => 'ajax-modal',
   'size' => Modal::SIZE_EXTRA_LARGE,
   'titleOptions' => [
      'id' => 'ajax-modal-title'
   ],
   'title' => 'Sedang memuat halaman ...',
   'bodyOptions' => [
      'id' => 'ajax-modal-body'
   ],
   'footer' => $this->render('_footer'),
   'footerOptions' => [
      'class' => 'd-flex'
   ]
]);
Modal::end();

$js = <<<JS
    
    const ajaxModal = document.getElementById('ajax-modal');
    const ajaxModalTitle = document.getElementById('ajax-modal-title');
    const ajaxModalBody = document.getElementById('ajax-modal-body');
    const ajaxModalFooter = document.getElementById('ajax-modal-footer');
    
   ajaxModal.addEventListener('shown.bs.modal', event => {
      jQuery.post(jQuery(event.relatedTarget).attr('href'), function(response){
         ajaxModalTitle.innerHTML = response.title;
         ajaxModalBody.innerHTML = response.content;
         ajaxModalFooter.innerHTML = response.footer;
      });
   });
   
   ajaxModal.addEventListener('hidden.bs.modal', () => {
      ajaxModalTitle.innerHTML = 'Sedang memuat halaman ...';
      ajaxModalBody.innerHTML= '';
      ajaxModalFooter.innerHTML= '';
   });

JS;

$this->registerJs($js);