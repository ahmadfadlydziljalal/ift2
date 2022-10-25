<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \app\generators\dzilcrud\generators\Generator */

$urlParams = $generator->generateUrlParams();
$labelID = empty($generator->labelID) ? $generator->getNameAttribute() : $generator->labelID;

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @see <?= $generator->controllerClass ?>::actionView() */

$this->title = $model-><?= $labelID ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= "<?= " ?>Html::a(<?= $generator->generateString('Kembali') ?>, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= "<?= " ?>Html::a(<?= $generator->generateString('Index') ?>, ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= "<?= " ?>Html::a(<?= $generator->generateString('Buat Lagi') ?>, ['create'], ['class' => 'btn btn-success']) ?>
            <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>,['update', <?= $urlParams ?>], ['class' => 'btn btn-outline-primary']) ?>
            <?= "<?php \n"?>
                if(Helper::checkRoute('delete')) :
                    echo Html::a(<?= $generator->generateString('Hapus') ?>, ['delete', <?= $urlParams ?>], [
                        'class' => 'btn btn-outline-danger',
                        'data' => [
                        'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                        'method' => 'post',
                    ],
                ]);
                endif;
            ?>
        </div>
    </div>
<?php $timestamp = ['created_at', 'updated_at',] ?>
<?php $blameable = ['created_by', 'updated_by',] ?>

    <?= "<?php try {
        echo " ?>DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
<?php
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {

            if ($name == 'id') {
                continue;
            }
            echo "'" . $name . "',\n";
        }

    } else {

        foreach ($generator->getTableSchema()->columns as $column) {

            if( $column->name == 'id'){
                continue;
            }

            $format = $generator->generateColumnFormat($column);

            if(in_array($column->name, $timestamp)){
                echo "           [
                    'attribute' => '" . $column->name . "',\n" .
                    "                    'format' => 'datetime'," .
                    "            \n           ],\n";
                continue;
            }


            if(in_array($column->name, $blameable)){
                echo "           [
                    'attribute' => '" . $column->name . "',\n" .
                    "                    'value' => function(\$model){ return app\models\User::findOne(\$model->$column->name)->username; }" .
                    "            \n           ],\n";
                continue;
            }

            echo "                  '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    } ?>
            ],
        ]);
    }catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>