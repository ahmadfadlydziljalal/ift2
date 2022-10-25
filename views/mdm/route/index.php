<?php

use mdm\admin\AnimateAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $routes [] */

$this->title = Yii::t('rbac-admin', 'Routes');
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'routes' => $routes,
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="bi glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<h1><?= Html::encode($this->title); ?></h1>
<div class="row">
    <div class="col-12">
        <div class="input-group mb-3">
            <input id="inp-route" type="text" class="form-control"
                   placeholder="<?= Yii::t('rbac-admin', 'New route(s)'); ?>"
                   aria-label="<?= Yii::t('rbac-admin', 'New route(s)'); ?>" aria-describedby="button-addon2">
            <?= Html::a(Yii::t('rbac-admin', 'Add'), ['create'], [
                'class' => 'btn btn-success',
                'id' => 'btn-new',
            ]); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <div class="input-group mb-3">
            <input class="form-control search" data-target="available"
                   placeholder="<?= Yii::t('rbac-admin', 'Search for available'); ?>">
            <?= Html::a('<i class="bi bi-arrow-clockwise"></i>', ['refresh'], [
                'class' => 'btn btn-outline-success',
                'id' => 'btn-refresh',
            ]); ?>
        </div>

        <select multiple size="20" class="form-control list" data-target="available"></select>
    </div>

    <div class="col-sm-2 text-center">
        <br><br>
        <br><br>
        <div class="d-grid gap-2">
        <?= Html::a('&gt;&gt;' . $animateIcon, ['assign'], [
            'class' => 'btn btn-success btn-assign',
            'data-target' => 'available',
            'title' => Yii::t('rbac-admin', 'Assign'),
        ]); ?><br><br>
        <?= Html::a('&lt;&lt;' . $animateIcon, ['remove'], [
            'class' => 'btn btn-danger btn-assign',
            'data-target' => 'assigned',
            'title' => Yii::t('rbac-admin', 'Remove'),
        ]); ?>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="input-group mb-3">
            <input class="form-control search" data-target="assigned"
                   placeholder="<?= Yii::t('rbac-admin', 'Search for assigned'); ?>">
        </div>

        <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
</div>