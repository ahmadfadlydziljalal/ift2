<?php

/** @see \app\controllers\FakturController::actionIndex()  */
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FakturSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Html;

$this->title = 'Faktur';
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="faktur-index">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
            <div class="ms-md-auto ms-lg-auto">
                <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php try {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                        'class' => 'table table-striped'
                ],
                'columns' => require(__DIR__ . '/_columns.php'),
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        } catch (Throwable $e) {
            echo $e->getMessage();
        } ?>

    </div>

<?php

Modal::begin([
    'id' => 'modal',
    'title' => 'Test',
    'size' => Modal::SIZE_EXTRA_LARGE,
    'footer' => '',
    'footerOptions' => [
            'class' => 'd-flex flex-row'
    ]
]);
Modal::end();
?>

<?php
$js = <<<JS
jQuery(document).ready(function(){
    
    let modal = jQuery('#modal');
    let modalTitle = modal.find('#modal-label');
    let modalBody = modal.find('.modal-body');
    let modalFooter = modal.find('.modal-footer');
    
    jQuery('.preview-print').click(function(e){
       
       e.preventDefault();
       
       modalTitle.html('Loading ...');
       jQuery.get(jQuery(this).attr('href'),  function(response){
           modalTitle.html(response.title);
           modalBody.html(response.content);
           modalFooter.html(response.footer);
       });
       
       modal.modal('show');
       
       /*if (modal.data('bs.modal').isShown) {
            modal.find('#modalContent').load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
       } else {
        //if modal isn't open; open it and load content
            modal.modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
       }*/
    }); 
});
JS;

$this->registerJs($js);