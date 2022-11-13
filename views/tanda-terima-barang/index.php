<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TandaTerimaBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tanda Terima Barang';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tanda-terima-barang-index">

    <div class="d-flex justify-content-between align-items-center mb-2">

        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>

        <div class="ms-md-auto ms-lg-auto">
            <?= Html::a('<i class="bi bi-repeat"></i>' . ' Reset Filter', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['tanda-terima-barang/before-create'], ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => require(__DIR__ . '/_columns.php'),
            'panel' => false,
            'bordered' => true,
            'striped' => false,
            'headerContainer' => [],
        ]);
    } catch (Exception $e) {
        echo $e->getTraceAsString();
    }
    ?>

</div>