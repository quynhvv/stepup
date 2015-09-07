<?php

namespace letyii\jstree;

use yii\helpers\Html;
use yii\helpers\Json;

class JsTree extends \yii\base\Widget
{

    /**
     * JsTree items
     * @see http://www.jstree.com/docs/json/
     * @var array
     */
    public $items;

    /**
     * JsTree options
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var string the template for arranging the jstree and the hidden input tag.
     */
//    public $template = '{input}{jstree}';

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        JsTreeAsset::register($this->getView());
        $this->options['id'] = isset($this->options['id']) ? $this->options['id'] : $this->getId();
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $clientOptions = $this->getClientOptions();
        $clientOptions = empty($clientOptions) ? '' : Json::encode($clientOptions);
        $view = $this->getView();
        $view->registerJs("
            jQuery('#" . $this->options['id'] . "')
                .on('loaded.jstree', function() { jQuery(this).jstree('select_node', jQuery('#" . $this->options['id'] . "').val().split(','), true); })
                .on('changed.jstree', function(e, data) { jQuery('#" . $this->options['id'] . "').val(data.selected.join()); })
                .jstree($clientOptions);
        ");
        echo Html::tag('div', '', $this->options);
    }
    
    /**
     * Returns the options for jstree
     * @return array
     */
    protected function getClientOptions()
    {
        $options = $this->clientOptions;
        
        if ($this->items !== null)
            $options['core']['data'] = $this->items;
        
        $options['core']['check_callback'] = isset($options['core']['check_callback']) ? $options['core']['check_callback'] : true;
                
        return $options;
    }
}
