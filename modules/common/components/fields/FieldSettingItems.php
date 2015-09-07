<?php

namespace app\modules\common\components\fields;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\account\models\AuthActionList;

class FieldSettingItems extends \yii\widgets\InputWidget {
    
    private $inputName;
    
	public function init() {
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control m-b-xs';
        
        $this->options['onkeydown'] = 'addItemWhenPressKey(event);';
        
        $this->inputName = Html::getInputName($this->model, $this->attribute);
        $this->registerAssets();
    }

	/**
	 * Renders the widget.
	 */
	public function run() {
        $items = Html::getAttributeValue($this->model, $this->attribute);
        
        // Generate key in items
        if (empty($items)) {
            $optionKey = 'option_' . rand(10000000, 99999999);
            $items = [
                $optionKey => '',
            ];
        }
        
        echo Html::beginTag('div', ['id' => 'items']);
        foreach ($items as $optionKey => $optionValue) {
            echo $this->createItem($optionKey, $optionValue);
        }
        
        // Tao ra bien hidden cua truong items, khi type = text thi truong items mac dinh bang rong
        if ($this->model->type == 'text')
            echo Html::hiddenInput($this->inputName, '', ['id' => 'itemEmpty']);
        
        echo Html::endTag('div');
        echo Html::button('', ['class' => 'fa fa-plus btn btn-success pull-right', 'id' => 'addItem']);
	}
    
    private function registerAssets(){
        $this->view->registerJs("
            $('#setting-type').change(function () {
                if (this.value == 'text') {
                    $('.field-setting-items').hide();
                    $('.field-setting-items input[type=text]').prop('disabled', true);
                    $('#itemEmpty').prop('disabled', false);
                } else if ($.inArray(this.value, ['radio', 'dropdown', 'checkbox']) != -1) {
                    $('#itemEmpty').remove();
                    $('.field-setting-items input').prop('disabled', false);
                    $('.field-setting-items').show();
                }
            }).change();
            
            $('#addItem').click(function(){
                addItem();
            });

            function addItemWhenPressKey(event){
                if (event.keyCode == 40 || event.keyCode == 45){
                    addItem();
                }
            }

            // Generate key in items
            function addItem() {
                var optionKey = 'option_' + Math.round(Math.random() * 100000000);
                var item = '".$this->createItem()."';
                item = item.replace('{optionKey}', optionKey);
                $('.field-setting-items #items').append(item);
                $('.field-setting-items #items input').last().focus();
            }
            
            // Remove item
            function removeItem(buttonRemove){
                $(buttonRemove).parent().parent().remove();
            }
            
            // Before save
            $('form').submit(function(){
                $('.field-setting-items input[type=text]').each(function(index) {
                    if ($(this).val().trim() == '') {
                        $(this).remove();
                    }
                });
            });

        ", yii\web\View::POS_END);
    }
    
    private function createItem($optionKey = '', $optionValue = ''){
        $result = Html::beginTag('div', ['class' => 'input-group m-b-xs']);
            $result .= Html::textInput($this->inputName . '[{optionKey}]', $optionValue, $this->options);
            $result .= Html::beginTag('div', ['class' => 'input-group-btn']);
                $result .= Html::button(Yii::t('yii', 'Delete'), ['class' => 'btn' ,'onclick' => 'removeItem(this)']);
            $result .= Html::endTag('div');
        $result .= Html::endTag('div');
        
        if (!empty($optionKey))
            $result = str_replace ('{optionKey}', $optionKey, $result);
        
        return $result;
    }
}

