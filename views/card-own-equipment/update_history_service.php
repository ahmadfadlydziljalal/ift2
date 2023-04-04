<?php

use app\models\CardOwnEquipmentHistory;
use yii\bootstrap5\Html;
use yii\web\View;


/* @var $this View */
/* @var $model CardOwnEquipmentHistory */

$this->title = 'Update Card Equipment History: ' . $model->cardOwnEquipment->nama;
$this->params['breadcrumbs'][] = ['label' => 'Card Own Equipment', 'url' => ['/card-own-equipment/index']];
$this->params['breadcrumbs'][] = ['label' => $model->cardOwnEquipment->nama . ' ' . $model->cardOwnEquipment->card->nama, 'url' => ['/card-own-equipment/view', 'id' => $model->cardOwnEquipment->id]];
$this->params['breadcrumbs'][] = 'Update History di ' . Yii::$app->formatter->asDate($model->tanggal_service_saat_ini);
?>

<div class="card-own-equipment-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_history_service', [
      'model' => $model,
   ]) ?>
</div>