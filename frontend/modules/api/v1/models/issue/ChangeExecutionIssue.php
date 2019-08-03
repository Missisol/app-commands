<?php

namespace frontend\modules\api\v1\models\issue;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\Issue;

class ChangeExecutionIssue extends ValidationModel
{
    public $id;
    public $execution;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id задачи не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Issue::class,
                'message' => 'Задачи с данным id не существует', ],

            ['execution', 'required', 'message' => 'Выполнение не может быть пустым.'],
            ['execution', 'integer'],
            ['execution', 'in', 'range' => [Issue::NO_EXECUTION, Issue::EXECUTION], 
                'message' => 'Выполнение может быть только 0 или 1']
        ];
    }

    public function changeExecution()
    {
        if (!$this->validate()) {
            return false;
        }

        $issue = Issue::findOne($this->id);
        $issue->execution = $this->execution;

        return $issue->save();
    }
}
