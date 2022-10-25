<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\dzilcrud\generators\Generator */

echo '<h3>General Configuration</h3>';
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'labelID');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');




echo "<hr />";
echo '<h3>Jika tidak terpakai, biarkan kosong </h3>';
echo '<h4 style="color: red">Master - Detail | Master Detail - Detail</h4>';
echo '<p>Jangan lupa, sesuaikan juga pilihan code template pada form paling bawah.</p>';
echo $form->field($generator, 'modelsClassDetail');
echo $form->field($generator, 'modelsClassDetailDetail');
echo "<hr />";
