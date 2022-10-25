<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\CardPersonInCharge */
/* @see app\controllers\CardPersonInChargeController::actionView() */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Card Person In Charge', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card-person-in-charge-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Update',['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?php 
                if(Helper::checkRoute('delete')) :
                    echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-outline-danger',
                        'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
                endif;
            ?>
        </div>
    </div>

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
                  'card_id',
                  'nama',
                  'telepon',
                  'email:email',
            ],
        ]);
    }catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>