<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\CreateNewEntity;

class CreateNewTask extends ValidationModel implements CreateNewEntity
{
    public $title;
    public $id_column;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название задачи не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия задачи - 255 символов.'],

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

        $position = Task::find()
            ->where(['id_column' => $this->id_column])
            ->max('position') + Task::INCREASE_POSITION;

        $task = new Task([
            'title' => $this->title,
            'position' => $position,
            'id_column' => $this->id_column,
        ]);

        return $task->save(false) 
            ? [
                'id' => $task->id,
                'position' => $position,
            ]
            : false;
    }
}
