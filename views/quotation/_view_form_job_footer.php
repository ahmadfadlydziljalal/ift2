<?php

/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div>
    <p>Remarks</p>
    <?= !empty($model->quotationFormJob->remarks) ? nl2br($model->quotationFormJob->remarks) : 'No Remarks!' ?>
</div>
