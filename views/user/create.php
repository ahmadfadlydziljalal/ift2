<?php



/* @var $this View */
/* @var $model User */

use app\models\User;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Create an user';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/admin/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>