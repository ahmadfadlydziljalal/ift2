<?php

use app\components\grid\ActionColumn as GridActionColumn;
use app\enums\TextLinkEnum;
use app\widgets\BreadcrumbsFlySystem;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$this->title = 'Spaces';
$this->params['breadcrumbs'][] = $this->title;

$root = isset(Yii::$app->request->queryParams['path']) ?
    Yii::$app->request->queryParams['path'] :
    Yii::$app->params['awsRootPath'];
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

                <?= Html::a(TextLinkEnum::BUAT_FOLDER->value, ['spaces/create-new-folder', 'root' => $root], [
                    'class' => 'btn btn-primary'
                ]) ?>

                <?= Html::a(TextLinkEnum::UPLOAD_FILE->value, ['spaces/upload-file', 'root' => $root], [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>
        </div>

    </div>

    <?php echo BreadcrumbsFlySystem::widget(); ?>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $contents
        ]),
        'columns' => [
            [
                'class' => SerialColumn::class
            ],
            [
                'attribute' => 'basename',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model['type'] === 'dir'
                        ? Html::a('<i class="bi bi-folder-fill"></i> ' . basename($model['path']), ['spaces/index', 'path' => $model['path']])
                        : '<i class="bi bi-file-earmark"></i> ' . basename($model['path']);
                }
            ],
            'size',
            'type',
            [
                'class' => GridActionColumn::class,
                'template' => '{download} {move-to-folder} {delete}',
                'buttons' => [
                    'download' => function ($url, $model) {
                        if ($model['type'] === 'dir') {
                            return '';
                        }
                        return Html::a('<i class="bi bi-cloud-download"></i>', ['spaces/download-file', 'key' => $model['path']], [
                            'class' => 'text-primary'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="bi bi-trash-fill"></i>', [
                            'delete',
                            'key' => $model['path'],
                            'type' => $model['type']
                        ], [
                            'class' => 'text-danger',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                        ]);
                    }
                ]
            ]
        ]
    ])
    ?>

</div>