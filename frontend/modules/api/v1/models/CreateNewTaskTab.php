<?php

namespace frontend\modules\api\v1\models;

use frontend\modules\api\v1\models\entity\TaskTab;
use frontend\modules\api\v1\models\entity\Board;

class CreateNewTaskTab extends ValidationModel
{
    public $name;
    public $id_board;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required', 'message' => 'Название вкладки задач не может быть пустым.'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия вкладки задач - 255 символов.'],

            ['id_board', 'required', 'message' => 'id_board не может быть пустым.'],
            ['id_board', 'integer'],
            [['id_board'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class, 'targetAttribute' => ['id_board' => 'id'], 'message' => 'Доски с данным id_board не существует']
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $taskTab = new TaskTab([
            'name' => $this->name,
            'id_board' => $this->id_board
        ]);

        return $taskTab->save(false);
    }
}
