<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\ThemeAsset;
use mdm\admin\components\MenuHelper;
use yii\bootstrap5\Html;
use yii\helpers\Inflector;

ThemeAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$topItems = MenuHelper::getAssignedMenu(Yii::$app->user->id, 15, function ($item) {
    $data = eval($item['data']);

    if (substr($item['name'], '0', '1') == '#') {
        return str_replace('#', '', $item['name']);
    }

    if (isset($data['module'])) {
        return isset($data['controller'])
            ?
            [
                'label' => $item['name'],
                'url' => [$item['route']],
                'items' => $item['children'],
                'icon' => $data['icon'] ?? null,
                'active' =>
                    Yii::$app->controller->module->id == $data['module'] &&
                    Yii::$app->controller->id == $data['controller']
            ]
            :
            [
                'label' => $item['name'],
                'url' => is_null($item['route']) ? "#" : [$item['route']],
                'items' => $item['children'],
                'icon' => $data['icon'] ?? null,
                'active' => null
            ];
    }

    return isset($data['controller'])
        ?
        [
            'label' => $item['name'],
            'url' => [$item['route']],
            'items' => $item['children'],
            'icon' => $data['icon'] ?? null,
            'active' => Yii::$app->controller->id == $data['controller']
        ]
        :
        [
            'label' => $item['name'],
            'url' => is_null($item['route']) ? "#" : [$item['route']],
            'items' => $item['children'],
            'icon' => $data['icon'] ?? null,
            'active' => null
        ];
});

$leftItems = MenuHelper::getAssignedMenu(Yii::$app->user->id, 16, function ($item) {

    $data = eval($item['data']);

    # menu bersifat divider saja
    if (isset($data['divider'])) {
        return [
            'label' => '',
            'options' => ['class' => 'dropdown-divider'],
        ];
    }

    $label = $item['name'];
    $collapsedId = Inflector::slug($item['name']);

    $options = $itemOptions = [];
    if (isset($item['children']) and !empty($item['children'])) {

        $isChildrenActive = array_column($item['children'], 'active');

        if (in_array(true, $isChildrenActive)) {
            $label = Html::tag(
                'div',
                Html::tag('span', $item['name']) . '<i class="bi bi-arrow-down-circle"></i>',
                [
                    'class' => 'd-flex justify-content-between align-items-center pe-1',
                ]
            );
        } else {
            $label = Html::tag(
                'div',
                Html::tag('span', $item['name']) . '<i class="bi bi-arrow-right-circle"></i>',
                [
                    'class' => 'd-flex justify-content-between align-items-center pe-1',
                ]
            );
        }

        $itemOptions = [
            'data-target' => '#' . $collapsedId,
            'class' => 'collapsed'
        ];
    }

    if (isset($data['module'])) {
        return isset($data['controller'])
            ?
            [
                'label' => $label,
                'url' => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
                'items' => $item['children'],
                'icon' => $data['icon'] ?? null,
                'active' =>
                    Yii::$app->controller->module->id == $data['module'] &&
                    Yii::$app->controller->id == $data['controller']
            ]
            :
            [
                'label' => $label,
                'url' => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
                'icon' => $data['icon'],

            ];
    }

    if (isset($data['controller'])) {
        return [
            'label' => $label,
            'url' => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
            'items' => $item['children'],
            'icon' => $data['icon'] ?? null,
            'options' => $options,
            'itemOptions' => $itemOptions,
            'active' => Yii::$app->controller->id == $data['controller']
        ];
    }

    return [
        'label' => $label,
        'url' => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
        'items' => $item['children'],
        'icon' => $data['icon'] ?? null,
        'options' => $options,
        'itemOptions' => $itemOptions,
        'active' => null
    ];
});

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column min-vh-100 <?= Yii::$app->params['theme'] ?>">

    <?php $this->beginBody() ?>

    <!-- Render header  -->
    <header class="top-navigation">
        <?= $this->render('_header', [
            'topItems' => $topItems,
            'leftItems' => $leftItems,
        ])
        ?>
    </header>

    <!-- Render content -->
    <main class="main">

        <!-- Render sidebar  -->
        <aside class="left-navigation">
            <?= $this->render('_sidebar', ['leftItems' => $leftItems]) ?>
        </aside>

        <!-- Render main content -->
        <section class="content mb-3">
            <?= $this->render('_content', ['content' => $content]) ?>
        </section>

    </main>

    <!-- Render footer -->
    <footer class="footer mt-auto shadow-sm">
        <?= $this->render('_footer') ?>
    </footer>

    <?php $this->endBody() ?>

    </body>

    </html>
<?php $this->endPage() ?>