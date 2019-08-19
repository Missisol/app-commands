<?php

namespace frontend\modules\api\v1\models\task;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\GetInfoByEntity;
use frontend\modules\api\v1\models\entity\Task;
use yii\helpers\ArrayHelper;

class GetInfoByTask extends ValidationModel implements GetInfoByEntity
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

        $task = Task::findOne($this->id);
        $labels = ArrayHelper::getColumn($task['labelTasks'], 'id_label');
        $task->labels = $labels;
        $task->setLabels($labels);

        return $task;
    }
}
