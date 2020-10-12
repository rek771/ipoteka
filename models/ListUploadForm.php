<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use app\models\Files;


class ListUploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $date_upload;

    public function rules()
    {
        return [
            [['date_upload'], 'default', 'value' => null],
            [['date_upload'], 'date'],
        ];
    }

    public function getList()
    {
        $files = Files::find()
            ->indexBy('id');

        return new ActiveDataProvider([
            'query' => $files,
            'sort' => [
                'defaultOrder' => [
                    'date_upload' => SORT_DESC,
                ]
            ],
        ]);
    }
}
