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
                <?= $model->cardTypeName ?>
                <p class="card-title">
                    <?= $model->nama ?> <br/> <small class="text-muted"><?= $model->kode ?></small>
                </p>
                <span><?= nl2br($model->alamat) ?></span>
            </div>

            <div class="align-self-center align-self-md-center ms-md-auto">
                <div class="d-flex flex-sm-row flex-md-column flex-lg-column gap-3">
                    <?= Html::a(TextLinkEnum::VIEW->value, ['card/view', 'id' => $model->id], [
                        'class' => 'text-decoration-none'
                    ]) ?>
                    <?= Html::a(TextLinkEnum::UPDATE->value, ['card/update', 'id' => $model->id], [
                        'class' => 'text-decoration-none'
                    ]) ?>
                    <?= Html::a(TextLinkEnum::DELETE->value, ['card/delete', 'id' => $model->id], [
                        'data' => [
                            'method' => 'POST',
                            'confirm' => 'Are you sure to delete this item ?'
                        ],
                        'class' => 'text-decoration-none text-danger'
                    ]) ?>
                </div>
            </div>
        </div>

    </div>

</div>