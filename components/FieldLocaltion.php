<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\location\models\LocationCity;
use app\modules\location\models\LocationDistrict;
use app\helpers\ArrayHelper;

class FieldLocaltion extends \kartik\widgets\FileInput {
    
    private $district = [];
    private $className;
    
    public function init(){
        $this->className = \yii\helpers\StringHelper::basename(get_class($this->model));
        $cities = LocationCity::find()->orderBy('title ASC')->all();
        foreach ($cities as $city) {
            $this->district[$city->_id] = ArrayHelper::map(LocationDistrict::find()->where(['region_id' => $city->_id])->orderBy('title ASC')->all(), '_id', 'title');
        }
            
        $this->registerJs();
    }

    public function run() {
        $output = '';
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control';
        
        if (!isset($this->options['id']) OR empty($this->options['id']))
            $this->options['id'] = 'locationCity';
        
        if (!isset($this->options['onchange']) OR empty($this->options['onchange']))
            $this->options['onchange'] = 'selected_region(this.value)';
        
        $cities = ArrayHelper::map(LocationCity::find()->orderBy('title ASC')->all(), '_id', 'title');
        $output = Html::activeDropDownList($this->model, $this->attribute, $cities, $this->options);
        $output .= '<div id="district"></div>';
        echo $output;
    }
    
    public function registerJs(){
        $this->district = addslashes(\yii\helpers\Json::encode($this->district));
        $district_id = 'district_id';
        $this->getView()->registerJs("
            var list='{$this->district}';
            list=eval('('+list+')');
            function selected_region(value){
                jQuery('#district').html('<select class=\"form-control\" name=\"{$this->className}[district]\" style=\"margin-top: 20px\" name=\"\" id=\"{$district_id}\"/></select>');
                if(value!=0){
                    jQuery('#{$district_id}').append(\"<option value='0' selected='selected'>-- Chọn Quận / Huyện --</option>\");
                    for(var i in list[value]){
                        jQuery('#{$district_id}').append('<option value='+i+'>'+list[value][i]+'</option>');
                    }
                }
            }
        ", yii\web\View::POS_END);
    }

}
