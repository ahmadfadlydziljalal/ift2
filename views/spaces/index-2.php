<?php

use app\enums\TextLinkEnum;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Spaces';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="spaces-index">
    <div class="d-flex flex-row">

        <div>
            <h1>Spaces</h1>
        </div>

        <div class="ms-auto">
            <div class="d-flex flex-row flex-nowrap gap-2">
                <div>
                    <input type="text" class="form-control" placeholder="Cari file ... " aria-label="Cari file ... ">
                </div>

                <?= Html::a(TextLinkEnum::BUAT_FOLDER->value, ['spaces/create-new-folder'], [
                    'class' => 'btn btn-primary'
                ]) ?>

                <?= Html::a(TextLinkEnum::UPLOAD_FILE->value, ['spaces/upload-file'], [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>
        </div>

    </div>

    <p>Path Breadcrumb disini</p>
    <?php


    echo Html::tag('pre', VarDumper::dumpAsString($contents));
    ?>

    <table class="table table-bordered table-striped">
        <tbody>
            <?php foreach ($contents as $object) { ?>
                <?php if ($object['Key'] == 'indoformosa/') continue; ?>

                <tr>
                    <td>
                        <?php

                        if (str_ends_with($object['Key'], '/')) {
                            echo

                            Html::a('<i class="bi bi-folder-fill"></i> ' . basename($object['Key']), ['spaces']);
                        } else {
                            echo '<i class="bi bi-file-earmark"></i> ' . basename($object['Key']);
                        }

                        // echo basename($object['Key']) . substr(($object['Key']), -1);
                        ?>
                    </td>
                    <td>

                        <?= Html::a('<i class="bi bi-cloud-download"></i>', ['spaces/download-file', 'key' => $object['Key']], [
                            'class' => 'text-primary'
                        ]); ?>

                        <?= Html::a('<i class="bi bi-folder-symlink"></i>', ['move-to-folder', 'key' => $object['Key']], [
                            'class' => 'text-warning'
                        ]); ?>

                        <?= Html::a('<i class="bi bi-trash-fill"></i>', [
                            'delete-file',
                            'key' => $object['Key'],
                        ], [
                            'class' => 'text-danger',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                        ]); ?>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>