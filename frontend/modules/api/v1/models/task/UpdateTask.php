<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateTask extends ValidationModel implements ActionByEntity
{
    public $id;
    public $title;
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

            [['title', 'description'], 'trim'],
            [['title', 'description'], 'default'],
            ['title', 'string', 'max' => 255, 'message' => 'Максимальная длина названия задачи - 255 символов.'],
            ['description', 'string', 'max' => 255, 'message' => 'Максимальная длина описания задачи - 255 символов.'],

            ['id', 'oneRequiredParam'],
        ];
    }

    public function oneRequiredParam()
    {
        if (!$this->hasErrors()) {
            if (null == $this->title && null == $this->description && null) {
                $this->addError('params', 'Обязательно должно быть передано название (title), '.
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

        if ($this->title) {
            $task->title = $this->title;
        }
        if ($this->description) {
            $task->description = $this->description;
        }

        return $task->save();
    }
}
