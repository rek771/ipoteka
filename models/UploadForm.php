<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use app\models\Files;
use yii\helpers\BaseInflector;

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
                $filename = BaseInflector::transliterate(mb_strtolower($file->baseName));
                $file->saveAs('uploads/' . $dir . '/' . $filename . '.' . $file->extension);
                $files = new Files();
                $files->file_path = 'uploads/' . $dir . '/' . $filename . '.' . $file->extension;
                $files->date_upload = date("Y-m-d H:i:s");
                $files->save();
//                Yii::$app->db->createCommand()->insert('files', [
//                    'file_path' => 'uploads/' . $dir . '/' . $filename . '.' . $file->extension,
//                    'date_upload' => date("Y-m-d H:i:s"),
//                ])->execute();
            }
            return true;
        } else {
            return false;
        }
    }
}
