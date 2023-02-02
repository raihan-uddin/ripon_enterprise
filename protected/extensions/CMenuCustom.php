<?php
Yii::import('zii.widgets.CMenu');

class CMenuCustom extends CMenu
{
    private $baseUrl;
    private $nljs;

    public $cssFile;
    public $activateParents = true;

    /**
     * Give the last items css 'last' style
     */
    protected function cssLastItems($items)
    {
        $i = max(array_keys($items));
        $item = $items[$i];

        if (isset($item['itemOptions']['class']))
            $items[$i]['itemOptions']['class'] .= ' last';
        else
            $items[$i]['itemOptions']['class'] = 'last';

        foreach ($items as $i => $item) {
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->cssLastItems($item['items']);
            }
        }

        return array_values($items);
    }

    /**
     * Give the last items css 'parent' style
     */
    protected function cssParentItems($items)
    {
        foreach ($items as $i => $item) {
            if (isset($item['items'])) {
                if (isset($item['itemOptions']['class']))
                    $items[$i]['itemOptions']['class'] .= ' parent';
                else
                    $items[$i]['itemOptions']['class'] = 'parent';

                $items[$i]['items'] = $this->cssParentItems($item['items']);
            }
        }

        return array_values($items);
    }

    /**
     * Initialize the widget
     */
    public function init()
    {
        if (!$this->getId(false))
            $this->setId('nav');

        $this->nljs = "\n";
//        $this->items = $this->cssParentItems($this->items);
//        $this->items = $this->cssLastItems($this->items);

        parent::init();
    }

    /**
     * Renders the menu items.
     * @param array $items menu items. Each menu item will be an array with at least two elements: 'label' and 'active'.
     * It may have three other optional elements: 'items', 'linkOptions' and 'itemOptions'.
     */
    protected function renderMenu($items)
    {
        if (count($items)) {
            echo CHtml::openTag('ul', $this->htmlOptions) . "\n";
            $this->renderMenuRecursive($items);
            echo CHtml::closeTag('ul');
        }
    }

    /**
     * Recursively renders the menu items.
     * @param array $items the menu items to be rendered recursively
     */
    protected function renderMenuRecursive($items)
    {
        foreach ($items as $item) {
            echo CHtml::openTag('li', isset($item['itemOptions']) ? $item['itemOptions'] : array());
            if (isset($item['url']))
                echo CHtml::link('<span>' . $item['label'] . '</span>', $item['url'], isset($item['linkOptions']) ? $item['linkOptions'] : array());
            else
                echo CHtml::link('<span>' . $item['label'] . '</span>', "", isset($item['linkOptions']) ? $item['linkOptions'] : array());
            if (isset($item['items']) && count($item['items'])) {
                echo "\n" . CHtml::openTag('ul', $this->submenuHtmlOptions) . "\n";
                $this->renderMenuRecursive($item['items']);
                echo CHtml::closeTag('ul') . "\n";
            }
            echo CHtml::closeTag('li') . "\n";
        }
    }


    protected function normalizeItems($items, $route, &$active, $ischild = 0)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if ($this->encodeLabel)
                $items[$i]['label'] = CHtml::encode($item['label']);
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $route, $hasActiveChild, 1);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if (($this->activateParents && $hasActiveChild) || $this->isItemActive($item, $route))
                    $active = $items[$i]['active'] = true;
                else
                    $items[$i]['active'] = false;
            } else if ($item['active'])
                $active = true;
            if ($items[$i]['active'] && $this->activeCssClass != '' && !$ischild) {
                if (isset($item['itemOptions']['class']))
                    $items[$i]['itemOptions']['class'] .= ' ' . $this->activeCssClass;
                else
                    $items[$i]['itemOptions']['class'] = $this->activeCssClass;
            }
        }
        return array_values($items);
    }


    /**
     * Run the widget
     */
    public function run()
    {
        $htmlOptions['id'] = 'nav-container-x';
        echo CHtml::openTag('div', $htmlOptions) . "\n";
        $htmlOptions['id'] = 'nav-bar-x';
        echo CHtml::openTag('div', $htmlOptions) . "\n";
        parent::run();
        echo CHtml::closeTag('div');
        echo CHtml::closeTag('div');
    }

}