<?php
/**
 * @var $model Log
 * @var $key int
 * @var $index string
 * */

use app\models\Log;
use yii\helpers\Html;

?>


<div class="card border-1">
    <div class="card-body">

        <div class="d-flex justify-content-between">
            <strong><?= $model->id ?></strong>
            <span class="card-title"><?= Yii::$app->formatter->asDatetime($model->log_time) ?></span>
        </div>


        <div class="d-flex flex-row my-3 gap-3">
            <?= Html::a(
                Html::tag('i', '', ['class' => 'bi bi-trash']) . ' Delete',
                ['log/delete', 'id' => (string)$model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'method' => 'POST',
                        'confirm' => 'Anda akan menghapus log ini ?'
                    ]
                ])
            ?>
        </div>

        <p><?= !isset($model->level) ? "" : "Level " . $model->level ?>,
            <?= !isset($model->category) ? "" : $model->category ?>
            <?= !isset($model->prefix) ? "" : ", " . $model->prefix ?>
        </p>
        <small class="card-text">
            <?= $model->message; ?>
        </small>
    </div>
</div>