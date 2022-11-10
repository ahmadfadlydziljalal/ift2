<?php
/** @var $model Card */

use app\enums\TextLinkEnum;
use app\models\Card;
use yii\helpers\Html;

?>

<div class="card h-100 rounded">
    <div class="card-body">

        <div class="d-flex gap-5 flex-column flex-md-row">
            <div>

                <strong><?= $model->cardTypeName ?></strong>

                <p class="card-title">
                    <i class="bi bi-person-badge"></i> <?= $model->nama ?> <br/>
                    <small class="text-muted"><?= $model->kode ?></small>
                </p>

                <span><?= nl2br($model->alamat) ?></span>

                <p>

                    <span class="badge bg-info rounded-circle"> <?= $model->mataUang->singkatan ?> </span> |
                    <?= (is_null($model->npwp) | empty($model->npwp))
                        ? Html::tag('span', 'NPWP is not available', ['class' => 'text-warning'])
                        : Html::tag('span', 'NPWP: ' . $model->npwp, ['class' => 'text-info'])
                    ?>
                </p>

            </div>


        </div>

    </div>

    <div class="card-footer p-2">
        <div class="d-flex flex-row align-items-end gap-3">
            <div>
                <?= Html::a(TextLinkEnum::VIEW->value, ['card/view', 'id' => $model->id], [
                    'class' => 'btn btn-outline-primary'
                ]) ?>
                <?= Html::a(TextLinkEnum::UPDATE->value, ['card/update', 'id' => $model->id], [
                    'class' => 'btn btn-outline-primary'
                ]) ?>

            </div>
            <div class="ms-auto">
                <?= Html::a(TextLinkEnum::DELETE->value, ['card/delete', 'id' => $model->id], [
                    'data' => [
                        'method' => 'POST',
                        'confirm' => 'Are you sure to delete this item ?'
                    ],
                    'class' => 'btn btn-outline-danger'
                ]) ?>

            </div>
        </div>
    </div>

</div>