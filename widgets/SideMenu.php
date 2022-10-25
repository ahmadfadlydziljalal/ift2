<?php

namespace app\widgets;

use Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\widgets\Menu;

class SideMenu extends Menu
{

    public string $icon = "play-circle";

    public $linkTemplate = '<a href="{url}" class="{class} d-flex flex-row align-items-center gap-2 m-0 ps-3 pe-1">
        <span>{icon}</span>
        <span>{label}</span>
    </a>';

    public string $linkWithDataTargetTemplate = '<a href="{url}" class="{class} d-flex flex-row align-items-center gap-2 m-0 ps-3 pe-1" data-bs-toggle="{data-bs-toggle}" aria-expanded="{aria-expanded}">
        <span>{icon}</span>
        <span class="flex-grow-1">{label}</span>
    </a>';

    public $submenuTemplate = "\n<ul class='submenu collapse {isShow}' id='{itemID}' >\n{items}\n</ul>\n";

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items): string
    {
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
                        '{icon}' => '<i class="bi bi-' . $iconClass . '"></i>',
                        '{items}' => $this->renderItems($item['items']),
                    ]);
                } else {
                    $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                    $menu .= strtr($submenuTemplate, [
                        '{isShow}' => null,
                        '{itemID}' => $itemID,
                        '{icon}' => '<i class="bi bi-' . $iconClass . '"></i>',
                        '{items}' => $this->renderItems($item['items']),
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
    protected function renderItem($item): string
    {

        $iconClass = $item['icon'] ?? $this->icon;

        if (isset($item['url'])) {

            $template = ArrayHelper::getValue($item, 'template', $this->linkWithDataTargetTemplate);
            if (isset($item['itemOptions']['data-target'])) {
                return strtr($template, [
                    '{url}' => Html::encode(Url::to($item['url'])),
                    '{label}' => $item['label'],
                    '{icon}' => '<i class="bi bi-' . $iconClass . '"></i>',
                    '{aria-expanded}' => 'false',
                    '{data-bs-toggle}' => 'collapse',
                    '{data-target}' => $item['itemOptions']['data-target'],
                    '{class}' => $item['itemOptions']['class'],

                ]);
            }

            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{class}' => $item['active'] ? $this->activeCssClass : '',
                '{icon}' => '<i class="bi bi-' . $iconClass . '"></i>',
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
}