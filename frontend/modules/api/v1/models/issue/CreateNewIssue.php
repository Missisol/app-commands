<?php

namespace frontend\modules\api\v1\models\issue;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\CreateNewEntity;
use frontend\modules\api\v1\models\entity\ListIssue;
use frontend\modules\api\v1\models\entity\Issue;

class CreateNewIssue extends ValidationModel implements CreateNewEntity
{
    public $description;
    public $id_listIssue;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['description', 'trim'],
            ['description', 'required', 'message' => 'Описание задачи не может быть пустым.'],
            ['description', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина описания задачи - 255 символов.'],

            ['id_listIssue', 'required', 'message' => 'id_listIssue не может быть пустым.'],
            ['id_listIssue', 'integer'],
            [['id_listIssue'], 'exist', 'skipOnError' => true, 'targetClass' => ListIssue::class, 'targetAttribute' => ['id_listIssue' => 'id'], 'message' => 'Список задач с данным id_listIssue не существует'],
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $issue = new Issue([
            'description' => $this->description,
            'id_listIssue' => $this->id_listIssue
        ]);

        return $issue->save(false);
    }
}
