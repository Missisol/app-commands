<?php

namespace frontend\modules\api\v1\models\column;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;
use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\entity\Column;

class ChangePositionColumn extends ValidationModel implements ActionByEntity
{
    public $id;
    public $position;
    public $id_board;

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

            ['position', 'integer'],
            ['position', 'required', 'message' => 'Позиция не может быть пустой.'],

            ['id_board', 'required', 'message' => 'id_board не может быть пустым.'],
            ['id_board', 'integer'],
            [['id_board'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class, 'targetAttribute' => ['id_board' => 'id'], 'message' => 'Доски с данным id_board не существует'],

            ['position', 'suitablePositionValue'],
        ];
    }

    public function suitablePositionValue()
    {
        if (!$this->hasErrors()) {
            $column = Column::findOne([
                'id_board' => $this->id_board,
                'position' => $this->position,
            ]);
            if ($column) {
                $this->addError('params', 'Данная позиция а этой доске уже занята');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $column = Column::findOne($this->id);
        $column->position = $this->position;

        return $column->save();
    }
}
