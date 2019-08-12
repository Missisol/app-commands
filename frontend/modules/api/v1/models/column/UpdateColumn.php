<?php

namespace frontend\modules\api\v1\models\column;

use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateColumn extends ValidationModel implements ActionByEntity
{
    public $id;
    public $title;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id колонки не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class,
                'message' => 'Колонки с данным id не существует', ],

            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название колонки не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'message' => 'Максимальная длина названия колонки - 255 символов.'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $column = Column::findOne($this->id);
        $column->title = $this->title;

        return $column->save();
    }
}
