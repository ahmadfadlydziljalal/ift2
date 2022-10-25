<?php


/* @var $this View */

/* @var $model User */

/* @var $response array | null */

use app\models\User;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Create an user with SIHRD Integration';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/admin/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create-with-sihrd-integration">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form_with_sihrd_integration', [
        'model' => $model,
        'response' => $response,
    ])
    ?>

</div>