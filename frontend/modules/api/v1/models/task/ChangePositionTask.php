<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class ChangePositionTask extends ValidationModel implements ActionByEntity
{
    public $id;
    public $position;
    public $id_column;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id задачи не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class,
                'message' => 'Задачи с данным id не существует', ],

            ['position', 'integer'],
            ['position', 'required', 'message' => 'Позиция не может быть пустой.'],

            ['id_column', 'required', 'message' => 'id_column не может быть пустым.'],
            ['id_column', 'integer'],
            [['id_column'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class, 'targetAttribute' => ['id_column' => 'id'], 'message' => 'Колонка с данным id_column не существует'],

            ['position', 'suitablePositionValue'],
        ];
    }

    public function suitablePositionValue()
    {
        if (!$this->hasErrors()) {
            $task = Task::findOne([
                'id_column' => $this->id_column,
                'position' => $this->position,
            ]);
            $listUser = ListUser::findOne([
                'id_column' => $this->id_column,
                'position' => $this->position,
            ]);
            if ($task || $listUser) {
                $this->addError('params', 'Данная позиция в этом столбце уже занята');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $task = Task::findOne($this->id);
        $task->id_column = $this->id_column;
        $task->position = $this->position;

        return $task->save();
    }
}
