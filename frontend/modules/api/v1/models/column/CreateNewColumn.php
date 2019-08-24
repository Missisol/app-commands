<?php

namespace frontend\modules\api\v1\models\column;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\CreateNewEntity;

class CreateNewColumn extends ValidationModel implements CreateNewEntity
{
    public $title;
    public $id_board;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название колонки не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия колонки - 255 символов.'],

            ['id_board', 'required', 'message' => 'id_board не может быть пустым.'],
            ['id_board', 'integer'],
            [['id_board'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class, 'targetAttribute' => ['id_board' => 'id'], 'message' => 'Доски с данным id_board не существует'],
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $position = Column::find()
            ->where(['id_board' => $this->id_board])
            ->max('position') + Column::INCREASE_POSITION;

        $column = new Column([
            'title' => $this->title,
            'id_board' => $this->id_board,
            'position' => $position
        ]);

        return $column->save(false) ? [
            'id' => $column->id,
            'position' => $position,
        ] : false;
    }
}
