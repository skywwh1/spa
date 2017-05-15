<?php
/**
 * Created by PhpStorm.
 * User: iven
 * Date: 2017/4/21
 * Time: 18:08
 */

namespace backend\models;


use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
//    /**
//     * @var UploadedFile
//     */
//    public $imageFile;


    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $file->saveAs('/var/www/html/spa/upload/financeUpload/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}