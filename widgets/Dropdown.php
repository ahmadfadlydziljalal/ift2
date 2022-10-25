<?php

namespace app\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap5\Dropdown as BS5Dropdown;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class Dropdown extends BS5Dropdown
{

    protected function renderItems(array $items, array $options = []): string
    {
        $lines = [];
        foreach ($items as $item) {
            if (is_string($item)) {
                $lines[] = ($item === '-')
                    ? Html::tag('hr', '', ['class' => 'dropdown-divider'])
                    : $item;
                continue;
            }
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = $item['encode'] ?? $this->encodeLabels;
            $icon = $item['icon'] ?? 'play-circle';
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $active = ArrayHelper::getValue($item, 'active', false);
            $disabled = ArrayHelper::getValue($item, 'disabled', false);

            Html::addCssClass($linkOptions, ['widget' => 'dropdown-item']);
            if ($disabled) {
                ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
                ArrayHelper::setValue($linkOptions, 'aria.disabled', 'true');
                Html::addCssClass($linkOptions, ['disable' => 'disabled']);
            } elseif ($active) {
                ArrayHelper::setValue($linkOptions, 'aria.current', 'true');
                Html::addCssClass($linkOptions, ['activate' => 'active']);
            }

            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if (empty($item['items'])) {
                if ($url === null) {
                    $content = Html::tag('h6', $label, ['class' => 'dropdown-header']);
                } else {

                    $label =
                        Html::beginTag('div', ['class' => 'd-flex flex-row', 'style' => ['gap' => '.5rem']]) .
                        Html::tag('i', '', [
                            'class' => 'bi bi-' . $icon
                        ]) . ' ' . $label .
                        Html::endTag('div');

                    $content = '<li>' . Html::a($label, $url, $linkOptions) . '</li>';
                }
                $lines[] = $content;
            } else {
                $submenuOptions = $this->submenuOptions;
                if (isset($item['submenuOptions'])) {
                    $submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
                }
                Html::addCssClass($submenuOptions, ['widget' => 'dropdown-submenu dropdown-menu']);
                Html::addCssClass($linkOptions, ['toggle' => 'dropdown-toggle']);

                $lines[] = Html::beginTag('div', array_merge_recursive(['class' => ['dropdown'], 'aria' => ['expanded' => 'false']], $itemOptions));
                $lines[] =
                    Html::a($label, $url, array_merge_recursive([
                        'data' => ['bs-toggle' => 'dropdown'],
                        'aria' => ['expanded' => 'false'],
                        'role' => 'button',
                    ], $linkOptions));
                $lines[] = static::widget([
                    'items' => $item['items'],
                    'options' => $submenuOptions,
                    'submenuOptions' => $submenuOptions,
                    'encodeLabels' => $this->encodeLabels,
                ]);
                $lines[] = Html::endTag('div');
            }
        }

        return Html::tag('ul', implode("\n", $lines), $options);
    }
}