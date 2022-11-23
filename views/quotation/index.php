<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\QuotationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\QuotationController::actionIndex() */

$this->title = 'Quotation';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="quotation-index">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </div>
    </div>

    <?php

    try {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'options' => [
                'class' => 'd-flex flex-column gap-3'
            ]
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }

    ?>

</div>