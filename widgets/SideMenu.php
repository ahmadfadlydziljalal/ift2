<?php

namespace app\widgets;

use Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\widgets\Menu;

class SideMenu extends Menu {
    private const PLACEHOLDER_URL = '{url}';
    private const PLACEHOLDER_CLASS = '{class}';
    private const PLACEHOLDER_ICON = '{icon}';
    private const PLACEHOLDER_LABEL = '{label}';
    private const PLACEHOLDER_ARIA_EXPANDED = '{aria-expanded}';
    private const PLACEHOLDER_DATA_BS_TOGGLE = '{data-bs-toggle}';
    private const PLACEHOLDER_DATA_TARGET = '{data-target}';

    public string $icon = "circle-half";

    public $linkTemplate = '<a href="' . self::PLACEHOLDER_URL . '" class="side-menu-link ' . self::PLACEHOLDER_CLASS . ' d-flex flex-row align-items-center m-0 px-3 py-2">
        <span class="side-menu-icon">' . self::PLACEHOLDER_ICON . '</span>
        <div class="side-menu-label flex-grow-1">' . self::PLACEHOLDER_LABEL . '</div>
    </a>';

    public string $linkWithDataTargetTemplate = '<a href="' . self::PLACEHOLDER_URL . '" class="side-menu-link side-menu-toggle ' . self::PLACEHOLDER_CLASS . ' d-flex flex-row align-items-center m-0 px-3 py-2" data-bs-toggle="' . self::PLACEHOLDER_DATA_BS_TOGGLE . '" data-bs-target="' . self::PLACEHOLDER_DATA_TARGET . '" aria-expanded="' . self::PLACEHOLDER_ARIA_EXPANDED . '">
        <span class="side-menu-icon">' . self::PLACEHOLDER_ICON . '</span>
        <div class="side-menu-label flex-grow-1">' . self::PLACEHOLDER_LABEL . '</div>
    </a>';

    public $submenuTemplate = "\n<ul class='submenu side-menu-submenu collapse {isShow}' id='{itemID}' >\n{items}\n</ul>\n";


    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     * @throws Exception
     */
    protected function renderItems($items): string {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {

                $itemID = Inflector::slug(strtolower(strip_tags($item['label'])));
                $iconClass = $item['icon'] ?? $this->icon;
                if ($item['active']) {
                    $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                    $menu .= strtr($submenuTemplate, [
                        '{isShow}' => 'show',
                        '{itemID}' => $itemID,
                        '{icon}'   => '<i class="bi bi-' . $iconClass . '"></i>',
                        '{items}'  => $this->renderItems($item['items']),
                    ]);
                } else {
                    $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                    $menu .= strtr($submenuTemplate, [
                        '{isShow}' => null,
                        '{itemID}' => $itemID,
                        '{icon}'   => '<i class="bi bi-' . $iconClass . '"></i>',
                        '{items}'  => $this->renderItems($item['items']),
                    ]);
                }
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * @param $item
     * @return string
     * @throws Exception
     */
    protected function renderItem($item): string {

        $iconClass = $item['icon'] ?? $this->icon;

        if (isset($item['url'])) {

            $template = ArrayHelper::getValue($item, 'template', $this->linkWithDataTargetTemplate);
            if (isset($item['itemOptions']['data-target'])) {
                return strtr($template, [
                    '{url}'            => Html::encode(Url::to($item['url'])),
                    '{label}'          => $item['label'],
                    '{icon}'           => '<i class="bi bi-' . $iconClass . '"></i>',
                    '{aria-expanded}'  => $item['active'] ? 'true' : 'false',
                    '{data-bs-toggle}' => 'collapse',
                    '{data-target}'    => $item['itemOptions']['data-target'],
                    '{class}'          => trim(($item['itemOptions']['class'] ?? '') . ' ' . ($item['active'] ? $this->activeCssClass : '')),

                ]);
            }

            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            return strtr($template, [
                '{url}'   => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{class}' => $item['active'] ? $this->activeCssClass : '',
                '{icon}'  => '<i class="bi bi-' . $iconClass . '"></i>',
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
}