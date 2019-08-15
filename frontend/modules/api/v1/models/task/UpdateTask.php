<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateTask extends ValidationModel implements ActionByEntity
{
    public $id;
    public $title;
    public $description;
    public $id_column;

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
            [['title', 'description', 'id_column'], 'default'],
            ['title', 'string', 'max' => 255, 'message' => 'Максимальная длина названия задачи - 255 символов.'],
            ['description', 'string', 'max' => 255, 'message' => 'Максимальная длина описания задачи - 255 символов.'],

            ['id_column', 'integer'],
            [['id_column'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class, 'targetAttribute' => ['id_column' => 'id'], 'message' => 'Колонка с данным id_column не существует'],

            ['id', 'oneRequiredParam'],
        ];
    }

    public function oneRequiredParam()
    {
        if (!$this->hasErrors()) {
            if (null == $this->title && null == $this->description && null == $this->id_column) {
                $this->addError('params', 'Обязательно должно быть передано название (title), '.
                    'описание задачи (description) или номер колонки(id_column).');
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
        if ($this->id_column) {
            $task->id_column = $this->id_column;
        }

        return $task->save();
    }
}
