<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\GetInfoByEntity;
use frontend\modules\api\v1\models\entity\Task;

class GetTasksByIdTask extends ValidationModel implements GetInfoByEntity
{
    public $id;

    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class,
                 'message' => 'Задачи с данным id не существует', ],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        return Task::findOne($this->id);
    }
}
