<?php

use app\models\User;
use mdm\admin\components\Helper;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$controllerId = $this->context->uniqueId . '/';
?>
<div class="user-view">


    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?php
            echo ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle"></i> Tambah',
                'encodeLabel' => false,
                'options' => [
                    'class' => 'p-0 m-0'
                ],
                'buttonOptions' => [
                    'class' => 'btn btn-success'
                ],
                'dropdown' => [
                    'options' => [
                        'class' => 'dropdown-menu-end'
                    ],
                    'items' => [
                        [
                            'label' => '<i class="bi bi-plus-circle"></i> Integrasi SIHRD',
                            'url' => ['create-with-sihrd-integration'],
                        ],
                        [
                            'label' => '<i class="bi bi-plus-circle"></i> Akun lokal',
                            'url' => ['create'],
                        ],
                    ],
                    'encodeLabels' => false
                ]
            ]);
            ?>
            <?php
            echo Html::a('<i class="bi bi-sign-turn-right"></i> Assign',
                ['assignment/view', 'id' => $model->id],
                [
                    'class' => 'btn btn-info'
                ]
            );
            ?>
            <?php
            $url = !is_null($model->karyawan_id) ? '/user/update-with-sihrd-integration' : '/user/update';
            echo Html::a('<i class="bi bi-pen"></i> Update',
                [$url, 'id' => $model->id],
                [
                    'class' => 'btn btn-primary'
                ]
            );
            ?>
            <?php
            if ($model->status == 0 && Helper::checkRoute($controllerId . 'activate')) {
                echo Html::a(Yii::t('rbac-admin', 'Activate'), ['activate', 'id' => $model->id], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                        'method' => 'post',
                    ],
                ]);
            }
            ?>
            <?php
            if (Helper::checkRoute($controllerId . 'delete')) {
                echo Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]);
            }
            ?>
        </div>
    </div>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            'created_at:date',
            'status',
        ],
    ])
    ?>

</div>