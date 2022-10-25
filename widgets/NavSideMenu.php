<?php

namespace app\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class NavSideMenu extends Nav
{

    public function __construct($config = [])
    {
        Html::addCssClass($this->options, ['widget' => 'list-unstyled ps-0']);
        parent::__construct($config);
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {

        parent::init();
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }

    }

    /**
     * Renders widget items.
     * @return string
     * @throws InvalidConfigException|Throwable
     */
    public function renderItems(): string
    {
        $items = [];
        foreach ($this->items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $items[] = $this->renderItem($item);
        }

        return Html::tag('ul', implode("\n", $items), $this->options);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     * @throws Throwable
     */
    public function renderItem($item): string
    {
        if (is_string($item)) {
            return '<strong class="py-2 px-1 d-flex w-100 align-items-center fw-semibold"> ' . $item . ' </strong>';
        }

        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = $item['encode'] ?? $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $icon = $item['icon'] ?? 'play-circle';
        $options = ArrayHelper::getValue($item, 'options', [
            'class' => 'mb-1'
        ]);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', [
            'class' => 'text-decoration-none px-3 py-2 d-block'
        ]);
        $disabled = ArrayHelper::getValue($item, 'disabled', false);
        $active = $this->isItemActive($item);

        if (empty($items)) {
            $items = '';
            if ($this->activateItems && $active) {
                Html::addCssClass($options, ['activate' => 'active']);
            }
            Html::addCssClass($linkOptions, ['widget' => '']);
        } else {
            $linkOptions['data']['bs-toggle'] = 'dropdown';
            $linkOptions['role'] = 'button';
            $linkOptions['aria']['expanded'] = 'false';
            Html::addCssClass($options, ['widget' => 'dropdown nav-item']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle nav-link']);
            if (is_array($items)) {
                $items = $this->isChildActive($items, $active);
                $items = $this->renderDropdown($items, $item);
            }
        }

        if ($disabled) {
            ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
            ArrayHelper::setValue($linkOptions, 'aria.disabled', 'true');
            Html::addCssClass($linkOptions, ['disable' => 'disabled']);
        } elseif ($this->activateItems && $active) {
            Html::addCssClass($linkOptions, ['activate' => 'active']);
        }

        $label =
            Html::beginTag('div', ['class' => 'd-flex flex-row', 'style' => ['gap' => '.5rem']]) .
            Html::tag('i', '', [
                'class' => 'bi bi-' . $icon
            ]) . ' ' . $label .
            Html::endTag('div');
        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }
}