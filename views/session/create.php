<?php
/* @var $this yii\web\View */
/* @var $model app\models\Session */
/* @see app\controllers\SessionController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Session';
$this->params['breadcrumbs'][] = ['label' => 'Session', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="session-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>