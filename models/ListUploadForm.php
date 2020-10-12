<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveQuery ;
use yii\data\ActiveDataProvider ;
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

    public function get_list()
    {
        if ($this->date_upload != null) {
            $files = Files::find()
                ->where(['like', 'date_upload', $this->date_upload])
                ->orderBy('date_upload');
//            $query = (new ActiveQuery())->from('files')->where(['like', 'date_upload', $this->from_date]);
        } else {
            $files = Files::find()
                ->indexBy('id');
        }

        $provider = new ActiveDataProvider([
            'query' => $files,
            'sort' => [
                'defaultOrder' => [
                    'date_upload' => SORT_DESC,
                ]
            ],
        ]);

        return $provider;
    }
}
