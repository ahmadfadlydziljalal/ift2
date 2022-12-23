<?php


/** @see \app\controllers\SiteController::actionIndex() */

/* @var $this View */


use yii\web\View;

$this->title = 'Dashboard';

?>

<div class="site-index d-flex flex-column">

   <?= $this->render('_alur_pembelian_barang') ?>

   <?= $this->render('_alur_pengeluaran_barang') ?>

   <?= $this->render('_alur_inventaris') ?>


</div>