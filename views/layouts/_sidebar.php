<?php

/**
 * @var $leftItems array
 * */

/* @var $this View */

use app\widgets\SideMenu as Menu;
use yii\web\View;


?>

<aside class="sidebar" id="side-nav">

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

</aside>