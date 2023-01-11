<?php

use app\components\helpers\ArrayHelper;
use app\models\Card;
use app\models\search\StockPerGudangByCardAsDiagramSearch;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\View;

/* @var $this View */
/* @var $searchModel StockPerGudangByCardAsDiagramSearch */
/* @var $card Card */

$this->title = 'Stock di ' . $card->nama;
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="stock-per-gudang-view">
        <div class="d-flex flex-column gap-2">
            <div class="d-flex justify-content-between flex-wrap align-items-center">
                <div>
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>

                <div>
                   <?= Html::a('<i class="bi bi-table"></i> As Table', ['stock-per-gudang/view-per-card', 'id' => Yii::$app->request->queryParams['id']], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>

           <?php
           $query = $searchModel->getQuery();
           $data = $query->all(); ?>
           <?php
           $arrayKeys = array_keys($data[0]);
           unset($arrayKeys[0]); // value Id

           $arrayKeyFirst = array_values(array_map(function ($el) {
              return Inflector::humanize($el);
           }, $arrayKeys));

           ?>
           <?php
           $maxColumn = max(array_column($data, 'block'));
           $columns = range('A', $maxColumn);
           ?>
           <?php
           $maxRow = max(array_column($data, 'row'));
           $rows = range(1, $maxRow)
           ?>
           <?php
           $data = ArrayHelper::index($data, 'id', [function ($element) {
              return $element['block'];
           }, 'row']);
           ksort($data);
           ?>
            <table class="table table-sm table-bordered">

                <thead>
                <tr class="text-center">
                    <th></th>
                   <?php foreach ($columns as $column) : ?>
                       <th>
                          <?= $column ?>
                       </th>
                   <?php endforeach; ?>
                </tr>
                </thead>

                <tbody>
                <?php $pad = ''; ?>
                <?php foreach ($rows as $key => $value) : ?>
                   <?php $pad = (str_pad($value, 2, "0", STR_PAD_LEFT)); ?>
                    <tr>
                        <td class="text-end" style="width:2em"><?= $pad ?></td>
                       <?php foreach ($columns as $column) : ?>
                          <?php if (isset($data[$column][$pad]))  : ?>

                               <td class="text-center" style="width:6em">
                                  <?= Html::button($column . '' . $pad, [
                                     'class' => 'btn btn-primary btn-sm',
                                     'data' => [
                                        'bs-toggle' => 'modal',
                                        'bs-target' => '#modal',
                                        'bs-title' => $column . $pad,
                                        'bs-key' => Json::encode($arrayKeyFirst),
                                        'bs-data' => Json::encode($data[$column][$pad]),
                                     ]
                                  ]) ?>
                               </td>
                          <?php else: ?>
                               <td class="text-center" style="width:6em"></td>
                          <?php endif; ?>
                       <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

<?php
Modal::begin([
   'id' => 'modal',
   'size' => Modal::SIZE_EXTRA_LARGE,
   'titleOptions' => [
      'id' => 'modal-title'
   ],
   'title' => 'Sedang memuat halaman ...',
   'bodyOptions' => [
      'id' => 'modal-body'
   ],
   'footer' => '<div class="me-auto"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> </div>',
   'footerOptions' => [
      'class' => 'd-flex'
   ]
]);
Modal::end();
?>

<?php
$js = <<<JS
    
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');
    // const modalFooter = document.getElementById('modal-footer');
    
   modal.addEventListener('shown.bs.modal', event => {
       
       modalTitle.innerHTML = event.relatedTarget.dataset.bsTitle;
       
       let htmlTable = '<div class="table-responsive">'; 
       htmlTable += '<table class="table table-bordered"> ' + '<thead>' + '<tr class="text-nowrap">'; 
       
       let headerTable =  JSON.parse(event.relatedTarget.dataset.bsKey);
       headerTable.forEach(function callback(value, index){
           htmlTable += "<th>" + value + "</th>";
       });
       htmlTable += '</tr>' + '</thead>' + '<tbody>';
       
       let bodyTable =  JSON.parse(event.relatedTarget.dataset.bsData);
       for (const key in bodyTable) {
           const item = bodyTable[key];
           htmlTable += '<tr>' ;
           
           for(const keyItem in item){
               console.log(keyItem);
               if(keyItem === 'id'){
                   continue;
               }
              const column = item[keyItem];
              htmlTable += '<td class="text-nowrap">' + column+ '</td>' ;
           }
           htmlTable += '</tr>' ;
       }
       htmlTable += '</tbody>' + '</table>' + '</div>';
       modalBody.innerHTML =  htmlTable;
   });
   
   modal.addEventListener('hidden.bs.modal', () => {
      modalTitle.innerHTML = 'Sedang memuat halaman ...';
      modalBody.innerHTML= '';
      // modalFooter.innerHTML= '';
   });

JS;

$this->registerJs($js);