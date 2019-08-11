<?php

namespace frontend\modules\api\v1\models\listIssue;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\ListIssue;
use frontend\modules\api\v1\models\entity\ColumnList;
use frontend\modules\api\v1\models\ActionByEntity;

class CreateNewListIssue extends ValidationModel implements ActionByEntity
{
    public $name;
    public $id_columnList;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required', 'message' => 'Название списка задач не может быть пустым.'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия списка задач - 255 символов.'],

            ['id_columnList', 'required', 'message' => 'id_columnList не может быть пустым.'],
            ['id_columnList', 'integer'],
            [['id_columnList'], 'exist', 'skipOnError' => true, 'targetClass' => ColumnList::class, 'targetAttribute' => ['id_columnList' => 'id'], 'message' => 'Колонка с данным id_columnList не существует'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $listIssue = new ListIssue([
            'name' => $this->name,
            'id_columnList' => $this->id_columnList
        ]);

        return $listIssue->save(false);
    }
}
