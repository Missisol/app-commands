<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateTask extends ValidationModel implements ActionByEntity
{
    public $id;
    public $name;
    public $description;

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
            ['id', 'required', 'message' => 'id задачи не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class,
                'message' => 'Задачи с данным id не существует', ],

            [['name', 'description'], 'trim'],
            [['name', 'description'], 'default'],
            ['name', 'string', 'max' => 255, 'message' => 'Максимальная длина названия задачи - 255 символов.'],
            ['description', 'string', 'max' => 255, 'message' => 'Максимальная длина описания задачи - 255 символов.'],
            ['id', 'oneRequiredParam'],
        ];
    }

    public function oneRequiredParam()
    {
        if (!$this->hasErrors()) {
            if (null == $this->name && null == $this->description) {
                $this->addError('params', 'Обязательно должно быть передано название (name) '.
                    'или описание задачи (description).');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $task = Task::findOne($this->id);

        if ($this->name) {
            $task->name = $this->name;
        }
        if ($this->description) {
            $task->description = $this->description;
        }

        return $task->save();
    }
}
