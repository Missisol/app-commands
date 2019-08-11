<?php

namespace frontend\modules\api\v1\models\issue;

use frontend\modules\api\v1\models\entity\ListIssue;
use frontend\modules\api\v1\models\entity\Issue;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\GetInfoByEntity;

class GetIssuesByIdListIssue extends ValidationModel implements GetInfoByEntity
{
    public $id_listIssue;

    public function rules()
    {
        return [
            ['id_listIssue', 'required', 'message' => 'id_listIssue не может быть пустым.'],
            ['id_listIssue', 'integer'],
            [['id_listIssue'], 'exist', 'skipOnError' => true, 'targetClass' => ListIssue::class, 'targetAttribute' => ['id_listIssue' => 'id'], 'message' => 'Списка задач с данным id_listIssue не существует'],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $issue = Issue::findAll([
            'id_listIssue' => $this->id_listIssue,
        ]);

        return [
            'issues' => $issue
        ];
    }
}
