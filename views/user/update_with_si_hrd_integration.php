<?php


/* @var $this View */
/* @var $model User|null */

/* @var $response array | null */

use app\models\User;
use yii\bootstrap5\Alert;
use yii\bootstrap5\Html;
use yii\web\View;


$this->title = 'Update user: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['/admin/user/index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['/admin/user/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="user-update">

    <?php if (Yii::$app->session->hasFlash('errorKarenaOrangBerbeda')): ?>
        <?= Alert::widget([
            'body' => 'Sistem tidak mengizinkan mengganti orang dari <strong>' .
                $response['nama_karyawan'] . '</strong> ke <strong>' . $model->nama_karyawan . '</strong>',
            'options' => [
                'class' => 'alert-danger'
            ]
        ]);
        ?>
    <?php endif; ?>

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?= $this->render('_form_with_sihrd_integration', [
        'model' => $model,
        'response' => $response

    ]); ?>
</div>