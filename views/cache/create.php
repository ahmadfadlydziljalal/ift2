<?php
/* @var $this yii\web\View */
/* @var $model app\models\Cache */
/* @see app\controllers\CacheController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Cache';
$this->params['breadcrumbs'][] = ['label' => 'Cache', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cache-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>