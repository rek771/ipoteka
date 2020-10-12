<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $uploadedFiles;

    public function rules()
    {
        return [
            [['uploadedFiles'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 5],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dir = Yii::$app->getSecurity()->generateRandomString(15);
            mkdir('uploads/' . $dir);
            foreach ($this->uploadedFiles as $file) {
                $filename = mb_strtolower($file->baseName);
                $filename = strtr($filename, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
                    'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
                    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
                    'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y',
                    'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
                $file->saveAs('uploads/' . $dir . '/' . $filename . '.' . $file->extension);
                Yii::$app->db->createCommand()->insert('files', [
                    'file_path' => 'uploads/' . $dir . '/' . $filename . '.' . $file->extension,
                    'date_upload' => date("Y-m-d H:i:s"),
                ])->execute();
            }
            return true;
        } else {
            return false;
        }
    }
}
