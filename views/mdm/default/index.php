<?php

use yii\helpers\Html;

$this->title = Yii::$app->name . ' Admin Page';

?>

<div class="admin-index">
    <p>Beberapa artikel penjelasan mengenai RBAC:</p>

    <ul>

        <li><?= Html::a('Apa itu RBAC ?', 'https://medium.com/pujanggateknologi/rbac-role-base-access-control-terdistribusi-f93fd0e9f95', ['target' => '_blank']) ?> </li>
        <li><?= Html::a('Konsep RBAC pada Yii2', 'https://www.yiiframework.com/doc/guide/2.0/en/security-authorization', ['target' => '_blank']) ?> </li>
        <li><?= Html::a('Ekstension Yii2 Admin', 'https://github.com/mdmsoft/yii2-admin', ['target' => '_blank']) ?> </li>
        <li><?= Html::a('Menggunakan Yii2 Admin', 'https://mdmunir.wordpress.com/2016/03/18/tutorial-penggunaan-mdmsoft-yii2-admin-1/', ['target' => '_blank']) ?> </li>
    </ul>
</div>