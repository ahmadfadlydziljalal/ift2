<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\CardController::actionIndex() */

$this->title = 'Card';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card-index">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </div>
    </div>

    <?php try {

        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'options' => [
                'class' => 'row'
            ],
            'itemOptions' => [
                'class' => 'col-sm-12 col-md-12 col-lg-4 mb-3'
            ]
        ]);
        
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }

    ?>
</div>