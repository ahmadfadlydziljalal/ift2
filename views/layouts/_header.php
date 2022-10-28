<?php


/**
 * @var $topItems array
 * @var $leftItems array
 * */

use app\components\helpers\ArrayHelper;
use app\widgets\Dropdown;
use kartik\select2\Select2;
use mdm\admin\components\MenuHelper;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

$brandLabel =
    Html::beginTag('div', ['class' => 'd-flex justify-content-between brand-wrapper align-items-baseline', 'style' => ['gap' => '1.25rem']]) .
    Html::button('<i class="bi bi-list"></i>', ['role' => 'button', 'type' => 'button', 'id' => 'btn-toggle-sidebar', 'class' => 'btn btn-link text-dark text-decoration-none rounded py-0 px-0 ']) .
    Html::a(
        "<div class='d-flex flex-row align-items-center' style='gap: .5rem'>" .
        Yii::$app->settings->get('site.icon') . (!Yii::$app->settings->get('site.name') ? Yii::$app->name : Yii::$app->settings->get('site.name')) .
        "</div>"
        , Yii::$app->homeUrl, ['class' => 'text-decoration-none ']) .
    Html::endTag('div');
?>


<?php NavBar::begin([
    'innerContainerOptions' => ['class' => 'container-fluid'],
    'brandLabel' => $brandLabel,
    'brandUrl' => null,
    'options' => [
        'id' => 'navbar',
        'class' => 'navbar navbar-expand-md navbar-' . Yii::$app->params['theme'] . ' fixed-top' . ' bg-' . Yii::$app->params['theme'] . ' shadow-sm',
    ],
    'togglerContent' => '<span class="bi bi-arrow-down-circle"></span>',
]); ?>

    <div class="search-navbar my-4 my-md-0 flex-sm-grow-1 flex-md-grow-0 float-md-end order-sm-0 order-md-0 order-lg-0">
        <?php
        try {
            echo Select2::widget([
                'id' => 'search-menu',
                'name' => 'search-menu',
                'data' => ArrayHelper::arrayValueRecursiveForSearchMenu('0', $leftItems),
                'options' => [
                    'placeholder' => 'Menu pencarian ... Ctrl + / ',
                ],
                'pluginOptions' => [
                    'dropdownAutoWidth' => true,
                    'width' => '100%'
                ],
                'pluginEvents' => [
                    'change' => "function(e) {
                    if($(this).val()){
                        window.location.replace($(this).val());
                    }
                }"
                ],
            ]);
        } catch (Exception $e) {
            echo '';
        }
        ?>
    </div>

<?php

if (!Yii::$app->user->isGuest) :
    try {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav flex-sm-grow-0 flex-md-grow-1 order-sm-0 order-md-1 order-lg-1'],
            'activateParents' => true,
            'dropdownClass' => Dropdown::class,
            'items' => $topItems
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }

    try {

        $profileImage =
            Html::beginTag('div', ['class' => 'd-flex flex-column align-items-center navbar-photo-profile px-3', 'style' => ['gap' => '.75rem']]) .
            (!empty(Yii::$app->cache->get('sihrd-user-image' . Yii::$app->user->identity->id)) ?
                Yii::$app->cache->get('sihrd-user-image' . Yii::$app->user->identity->id) :
                '<i class="bi bi-person-badge" style="font-size: 64px"></i>' . '<span>' . substr(Yii::$app->user->identity->username, 0, 7) . '</span>'
            )
            .
            Html::endTag('div');

        $dropdownItems = ArrayHelper::merge([$profileImage . '<div class="dropdown-divider"></div>'], MenuHelper::getAssignedMenu(Yii::$app->user->id, '28'));
        $dropdownItems[] = '<div class="dropdown-divider"></div>';
        $dropdownItems[] = '<div class="d-flex flex-row w-100">
                                <div class="col bg-primary text-white p-2"></div>
                                <div class="col bg-success text-white p-2"></div>
                                <div class="col bg-info p-2"></div>
                                <div class="col bg-warning p-2"></div>
                                <div class="col bg-danger text-white p-2"></div>
                            </div>';
        $dropdownItems[] = '<div class="dropdown-divider"></div>';
        $dropdownItems[] =
            [
                'label' => '<div class="d-flex justify-content-start" style="gap: 1rem"> <i class="bi bi-box-arrow-right"></i> <span>Log Out</span></div>',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];

        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav order-2 ms-auto'],
            'activateParents' => true,
            'items' => [
                [
                    'label' => (Yii::$app->params['theme'] === 'dark' ?
                        '<div class="d-flex" style="gap: .25rem"><i class="bi bi-sun"></i><span class="d-block d-sm-block d-md-none d-lg-none">Light Mode</span></div>' :
                        '<div class="d-flex" style="gap: .25rem"><i class="bi bi-moon"></i><span class="d-block d-sm-block d-md-none d-lg-none">Dark Mode</span></div>'),
                    'url' => ['/dark-light-toggle/index'],
                    'linkOptions' => [
                        'id' => 'dark-light-link',
                    ]
                ],
                [
                    'label' => '<i class="bi bi-person"> </i> ' . substr(Yii::$app->user->identity->username, 0, 7),
                    'dropdownOptions' => [
                        'class' => 'dropdown-menu dropdown-menu-end',
                        'style' => [
                            'min-width' => '12rem'
                        ],
                    ],
                    'options' => [],
                    'items' => $dropdownItems
                ],
            ],
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
endif;
?>

<?php NavBar::end(); ?>