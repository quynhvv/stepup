<?php
/**
 * @copyright Copyright (c) 2014 Let.,ltd
 * @author Ngua Go <nguago@let.vn>
 */

namespace letyii\cropper;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use yii\imagine\BaseImage;

class Cropper
{
    public $data;

    public $file;
    
    public $fileName;

    public $folder;
    
    private function getData(){
        return Json::decode($this->data);
    }

	public function crop() {
        $this->saveOriginal();
    }
    
    private function saveOriginal() {
        if (($ext = pathinfo($this->file, PATHINFO_EXTENSION)) !== '')
            $ext = strtolower($ext);
        
        FileHelper::createDirectory($this->folder);
        
        $path = $this->folder . DIRECTORY_SEPARATOR;
        $imageOriginal = $path . $this->fileName . '.original.' . $ext;
        
        // Neu anh la anh moi upload
        if (is_object($this->file)){
            $this->file->saveAs($imageOriginal);
        }
        
        // Get data image crop
        $data = $this->getData();
        
        // Crop image and save image
        BaseImage::crop($imageOriginal, $data['width'], $data['height'], [$data['x'], $data['y']])->rotate($data['rotate'])->save($path . $this->fileName . '.' . $ext);
    }
}
