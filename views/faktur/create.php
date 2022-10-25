<?php

/* @var $this yii\web\View */
/* @var $model app\models\Faktur */
/* @var $modelsDetail app\models\FakturDetail */

use yii\helpers\Html;
$this->title = 'Tambah Faktur';
$this->params['breadcrumbs'][] = ['label' => 'Faktur', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="faktur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>
</div>