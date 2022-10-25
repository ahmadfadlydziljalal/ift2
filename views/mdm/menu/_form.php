<?php

use mdm\admin\AutocompleteAsset;
use mdm\admin\models\Menu;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */

AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => Menu::getMenuSource(),
    'routes' => Menu::getSavedRoutes(),
]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

    <div class="menu-form">
        <?php $form = ActiveForm::begin([
            'layout' => ActiveForm::LAYOUT_FLOATING
        ]); ?>
        <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 128,
                    'autofocus' => 'autofocus'
                ]) ?>

                <?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name']) ?>

                <?= $form->field($model, 'route')->textInput(['id' => 'route']) ?>
            </div>

            <div class="col-sm-6">

                <?= $form->field($model, 'order')->input('number') ?>


                <div class="d-flex flex-column flex-lg-row mt-3" style="gap: 1rem">
                    <?= Html::button(' Activate By Controller', [
                        'class' => 'btn btn-outline-success',
                        'onClick' => 'activate("controller")'
                    ]) ?>
                    <?= Html::button(' Activate By Module', [
                        'class' => 'btn btn-outline-success',
                        'onClick' => 'activate("module")'
                    ]) ?>
                </div>

                <?= $form->field($model, 'data')->textarea([
                    'rows' => 6,
                    'style' => [
                        'height' => '12rem'
                    ]
                ]) ?>
            </div>
        </div>

        <div class="mt-3">
            <?=
            Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' =>
                $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

<?php


$js = <<<JS

    function activate(mode){     
    
        let route = jQuery('#route');
        let stringRoute =  route.val();
        let stringSplit = stringRoute.split("/");
        
        stringSplit.shift();
        stringSplit.pop();
        
        let controller = '';
        let module = '';
        let stringTemplate;
        
        if(mode === 'module'){
            module = stringSplit[0];
            controller = stringSplit[1];
            stringTemplate  = "return[" + "'module' => '" + module + "', 'controller' => '" + controller + "', 'icon' => 'play-circle'];";
        }else{
            controller = stringSplit[0];
            stringTemplate  = "return[" + "'controller' => '" + controller + "', 'icon' => 'play-circle'];";
        }
        
        jQuery('#menu-data').val(stringTemplate);
        
    }
JS;

$this->registerJs($js, View::POS_HEAD);