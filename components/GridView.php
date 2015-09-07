<?php

namespace app\components;

use yii\helpers\Html;
use app\helpers\ArrayHelper;

class GridView extends \kartik\grid\GridView {
    
    public function init() {
        return parent::init();
    }
    
    public function run()
    {
//        $this->panel['heading'] = FALSE;
        
        parent::run();
    }
    
    protected function initLayout() {
        $this->resizeStorageKey = empty($this->resizeStorageKey) ? date('Ymd') : $this->resizeStorageKey;
        parent::initLayout();
    }
    
    protected function renderPanel()
    {
        if (!$this->bootstrap || !is_array($this->panel) || empty($this->panel)) {
            return;
        }
        $type = 'panel-' . ArrayHelper::getValue($this->panel, 'type', 'default');
        $heading = ArrayHelper::getValue($this->panel, 'heading', '');
        $footer = ArrayHelper::getValue($this->panel, 'footer', '');
        $before = ArrayHelper::getValue($this->panel, 'before', '');
        $after = ArrayHelper::getValue($this->panel, 'after', '');
        $headingOptions = ArrayHelper::getValue($this->panel, 'headingOptions', []);
        $footerOptions = ArrayHelper::getValue($this->panel, 'footerOptions', []);
        $beforeOptions = ArrayHelper::getValue($this->panel, 'beforeOptions', []);
        $afterOptions = ArrayHelper::getValue($this->panel, 'afterOptions', []);
        $panelHeading = '';
        $panelBefore = '';
        $panelAfter = '';
        $panelFooter = '';

        if ($heading !== false) {
            Html::addCssClass($headingOptions, 'ibox-title');
            $content = strtr($this->panelHeadingTemplate, ['{heading}' => $heading]);
            $panelHeading = Html::tag('div', $content, $headingOptions);
        }
        if ($footer !== false) {
            Html::addCssClass($footerOptions, 'ibox-title');
            $content = strtr($this->panelFooterTemplate, ['{footer}' => $footer]);
            $panelFooter = Html::tag('div', $content, $footerOptions);
        }
        if ($before !== false) {
            Html::addCssClass($beforeOptions, 'kv-panel-before');
            $content = strtr($this->panelBeforeTemplate, ['{before}' => $before]);
            $panelBefore = Html::tag('div', $content, $beforeOptions);
        }
        if ($after !== false) {
            Html::addCssClass($afterOptions, 'kv-panel-after');
            $content = strtr($this->panelAfterTemplate, ['{after}' => $after]);
            $panelAfter = Html::tag('div', $content, $afterOptions);
        }
        $this->layout = strtr(
            $this->panelTemplate,
            [
                '{panelHeading}' => $panelHeading,
                '{type}' => $type,
                '{panelFooter}' => $panelFooter,
                '{panelBefore}' => $panelBefore,
                '{panelAfter}' => $panelAfter
            ]
        );
    }
}
