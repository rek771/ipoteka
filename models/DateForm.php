<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class DateForm extends Model
{
    public function rules()
    {
        return [
            ['selected_date', 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}