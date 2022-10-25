<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$plusIcon = '<i class="bi bi-plus-circle-dotted"></i>';
echo "<?php\n";
?>
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= "<?= " ?>Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= "<?= " ?>Html::a('<?= $plusIcon ?>'.<?= $generator->generateString(' Tambah') ?>, ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?= "<?php try { 
        echo " ?>GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => require(__DIR__.'/_columns.php'),
            'panel' => false,
            'bordered' => true,
            'striped' => false,
            'headerContainer' => [],
            ]);
        } catch(Exception $e){
            echo $e->getMessage();
        }<?= "\n         ?>\n"
    ?>

</div>