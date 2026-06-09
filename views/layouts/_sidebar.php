<?php

/**
 * @var $leftItems array
 * */

/* @var $this View */

use app\widgets\SideMenu as Menu;
use yii\web\View;


?>

<aside class="sidebar" id="side-nav">

    <div class="sidebar-shell">
        <div class="sidebar-header">
            <span class="sidebar-header-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </span>
            <div class="sidebar-header-copy">
                <p class="sidebar-header-eyebrow mb-0"><?= Yii::$app->user->identity->username ?></p>
                <h2 class="sidebar-header-title mb-0">Menu Utama</h2>
            </div>
        </div>

        <div class="sidebar-menu">
            <?php
            try {
                echo Menu::widget([
                    'activateParents' => true,
                    'encodeLabels'    => false,
                    'options'         => [
                        'class' => 'sidebar-nav'
                    ],
                    'items'           => $leftItems,
                ]);
            } catch (Throwable $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>

</aside>