<?php

use app\models\CardOwnEquipmentHistory;
use yii\bootstrap5\Html;
use yii\web\View;


/* @var $this View */
/* @var $model CardOwnEquipmentHistory */

$this->title = 'Tambah History Service';
$this->params['breadcrumbs'][] = ['label' => 'Card Own Equipment', 'url' => ['/card-own-equipment/index']];
$this->params['breadcrumbs'][] = 'Tambah History Service';
?>

<div class="card-own-equipment-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_history_service', [
      'model' => $model,
   ]) ?>
</div>