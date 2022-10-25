<?php

/**
 * @var $model Session
 * @var $key int
 * @var $index string
 * */


use app\models\Session;
use yii\helpers\Html;

?>

<div class="card border-1">
    <div class="card-body">

        <div class="d-flex justify-content-between">
            <strong><?= $model->id ?></strong>
            <span class="card-title"><?= Yii::$app->formatter->asDatetime($model->expire) ?></span>
        </div>
        <p><?= empty($model->user_id) ? 'No User' : $model->user->username ?>
            , <?= Yii::$app->formatter->asDatetime($model->last_write) ?></p>
        <p><?= $model->data ?></p>

    </div>

    <div class="card-footer p-3">
        <?= Html::a('<i class="bi bi-eye"></i> View', ['session/view', 'id' => $model->id], [
            'class' => 'text-primary text-decoration-none'
        ]); ?>
        <?= Html::a('<i class="bi bi-trash"></i> Delete', ['session/delete', 'id' => $model->id], [
            'class' => 'text-danger text-decoration-none',
            'data' => [
                'method' => 'POST',
                'confirm' => 'Anda akan menghapus session ini ?'
            ]
        ]); ?>
    </div>

</div>