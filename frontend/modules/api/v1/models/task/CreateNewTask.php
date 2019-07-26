<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\Column;

class CreateNewTask extends ValidationModel
{
    public $name;
    public $id_column;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required', 'message' => 'Название задачи не может быть пустым.'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия задачи - 255 символов.'],

            ['id_column', 'required', 'message' => 'id_column не может быть пустым.'],
            ['id_column', 'integer'],
            [['id_column'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class, 'targetAttribute' => ['id_column' => 'id'], 'message' => 'Колонка с данным id_column не существует'],
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $task = new Task([
            'name' => $this->name,
            'id_column' => $this->id_column
        ]);

        return $task->save(false);
    }
}
