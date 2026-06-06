<?php

/** @var yii\web\View $this */

/** @var string $content */

use mdm\admin\components\MenuHelper;
use yii\bootstrap5\Html;
use yii\helpers\Inflector;

$topItems = MenuHelper::getAssignedMenu(Yii::$app->user->id, 15, function ($item) {
    $data = eval($item['data']);

    if (substr($item['name'], '0', '1') == '#') {
        return str_replace('#', '', $item['name']);
    }

    if (isset($data['module'])) {
        return isset($data['controller'])
            ?
            [
                'label'  => $item['name'],
                'url'    => [$item['route']],
                'items'  => $item['children'],
                'icon'   => $data['icon'] ?? null,
                'active' =>
                    Yii::$app->controller->module->id == $data['module'] &&
                    Yii::$app->controller->id == $data['controller']
            ]
            :
            [
                'label'  => $item['name'],
                'url'    => is_null($item['route']) ? "#" : [$item['route']],
                'items'  => $item['children'],
                'icon'   => $data['icon'] ?? null,
                'active' => null
            ];
    }

    return isset($data['controller'])
        ?
        [
            'label'  => $item['name'],
            'url'    => [$item['route']],
            'items'  => $item['children'],
            'icon'   => $data['icon'] ?? null,
            'active' => Yii::$app->controller->id == $data['controller']
        ]
        :
        [
            'label'  => $item['name'],
            'url'    => is_null($item['route']) ? "#" : [$item['route']],
            'items'  => $item['children'],
            'icon'   => $data['icon'] ?? null,
            'active' => null
        ];
});
$leftItems = MenuHelper::getAssignedMenu(Yii::$app->user->id, 16, function ($item) {

    $data = eval($item['data']);

    # menu bersifat divider saja
    if (isset($data['divider'])) {
        return [
            'label'   => '',
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
            'class'       => 'collapsed'
        ];
    }

    if (isset($data['module'])) {
        return isset($data['controller'])
            ?
            [
                'label'  => $label,
                'url'    => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
                'items'  => $item['children'],
                'icon'   => $data['icon'] ?? null,
                'active' =>
                    Yii::$app->controller->module->id == $data['module'] &&
                    Yii::$app->controller->id == $data['controller']
            ]
            :
            [
                'label' => $label,
                'url'   => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
                'icon'  => $data['icon'],

            ];
    }

    if (isset($data['controller'])) {
        return [
            'label'       => $label,
            'url'         => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
            'items'       => $item['children'],
            'icon'        => $data['icon'] ?? null,
            'options'     => $options,
            'itemOptions' => $itemOptions,
            'active'      => Yii::$app->controller->id == $data['controller']
        ];
    }

    return [
        'label'       => $label,
        'url'         => is_null($item['route']) ? "#" . $collapsedId : [$item['route']],
        'items'       => $item['children'],
        'icon'        => $data['icon'] ?? null,
        'options'     => $options,
        'itemOptions' => $itemOptions,
        'active'      => null
    ];
});

?>

<?php $this->beginContent('@app/views/layouts/clear.php') ?>
<div class="d-flex flex-column min-vh-100">
    <!-- Render header  -->
    <header class="top-navigation">
        <?= $this->render('_header', [
            'topItems'  => $topItems,
            'leftItems' => $leftItems,
        ])
        ?>
    </header>

    <!-- Render content -->
    <main class="main flex-grow-1">

        <!-- Render sidebar  -->
        <aside class="left-navigation">
            <?= $this->render('_sidebar', ['leftItems' => $leftItems]) ?>
        </aside>

        <!-- Render main content -->
        <section class="content mb-3" style="padding-top: 72px">
            <?= $this->render('_content', ['content' => $content]) ?>
        </section>

    </main>

    <!-- Render footer -->
    <footer class="footer mt-auto shadow-sm">
        <?= $this->render('_footer') ?>
    </footer>
</div>

<?php $this->endContent(); ?>
