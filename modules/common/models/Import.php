<?php

namespace app\modules\common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use app\helpers\LetHelper;
use MongoDate;

/**
 * This is the model class for collection "import".
 *
 * @property \MongoId|string $_id
 * @property mixed $file_path
 * @property mixed $model_namespace
 * @property mixed $map
 */
class Import extends BaseImport {

    /**
     * Data get tu file
     * @var array|string|null
     */
    public $dataFile = null;

    public function rules() {
        return parent::rules();
    }

    public function scenarios() {
        return array_merge(Model::scenarios(), [
            'search' => ['file_path', 'model_namespace', 'map'],
            'default' => ['file_path', 'model_namespace', 'map']
        ]);
    }

    public function search($params, $pageSize = 20) {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'model' => $this->model,
//        ]);

        $query->andFilterWhere(['like', '_id', $this->_id])
                ->andFilterWhere(['like', 'file_path', $this->file_path])
                ->andFilterWhere(['like', 'model_namespace', $this->model_namespace]);

        if (\app\helpers\ArrayHelper::getValue($params, 'sort') == NULL)
            $query->orderBy('create_time DESC');

        return $dataProvider;
    }

    /**
     * Get path file
     * @return string Path cua file
     */
    public function getFilePath() {
        return LetHelper::getFileUploaded($this->file_path, LetHelper::PATH);
    }

    private function convertDataExcel() {
        
    }

    /**
     * Function import data excel for model
     */
    public function importDataExcel() {
        // Namespace of model
        $namespace = $this->model_namespace;
        
        // Neu ton tai $this->map va $this->map la 1 mang thi moi import data
        if (isset($this->map) && is_array($this->map)) {
            // Get all data excel and add new item model
            foreach ($this->getDataExcel() as $item) {
                // Get all key item
                $keysItem = array_keys($item);
                
                // Neu trong mang key co _id thi kiem tra xem du lieu co ton tai hay khong
                if (in_array('_id', $keysItem)) {
                    $model = $namespace::findOne($item['_id']);
                    if (!$model)
                        continue;
                } else {
                    // Tao moi model
                    $model = new $namespace;
                }  
//                $model->$itemMap = new MongoDate(strtotime(str_replace('/', '-', $item[$itemMap])))
                foreach ($this->map as $itemMap) {
                    // Neu column la create_time thi chuyen time binh thuong thanh mongo date
                    if (strstr($itemMap, 'time')){
                        $model->$itemMap = new MongoDate(strtotime(str_replace('/', '-', $item[$itemMap])));
                    }else 
                        $model->$itemMap = $this->checkDataType($item[$itemMap]);
                    
                }
                
                $model->save();
            }
        }
    }

    public function getFieldsExcel() {
        if (empty($this->dataFile)) {
            $excel = \PHPExcel_IOFactory::load($this->getFilePath());
            $this->dataFile = $excel->getActiveSheet()->toArray(null, true, true, true);
        }
        return current($this->dataFile);
    }

    public function checkDataType($value){
        if (is_numeric($value)) {
            if (!(substr($value, 0, 1) == 0) OR $value == '0')
                return intval($value);
        }
        return $value;
    }
    
    public function getDataExcel() {
        // Get field in excel
        $fields = $this->getFieldsExcel();
        if (empty($this->dataFile)) {
            $excel = \PHPExcel_IOFactory::load($this->getFilePath());
            $this->dataFile = $excel->getActiveSheet()->toArray(null, true, true, true);
        }
        
        $data = [];
        foreach ($this->dataFile as $key => $value) {
            if ($key == 1)
                continue;

            foreach ($fields as $fieldKey => $fieldValue) {
                if (isset($value[$fieldKey]))
                    $row[$this->map[$fieldValue]] = $value[$fieldKey];
            }
            $data[] = $row;
        }
        return $data;
    }

}
