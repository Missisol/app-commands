<?php

namespace frontend\modules\api\v1\models\columnList;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\ColumnList;
use frontend\modules\api\v1\models\entity\ListUser;

class CreateNewColumnList extends ValidationModel
{
    public $name;
    public $id_list;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required', 'message' => 'Название колонки не может быть пустым.'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия колонки - 255 символов.'],

            ['id_list', 'required', 'message' => 'id_list не может быть пустым.'],
            ['id_list', 'integer'],
            [['id_list'], 'exist', 'skipOnError' => true, 'targetClass' => ListUser::class, 'targetAttribute' => ['id_list' => 'id'], 'message' => 'Списка задач пользователя с данным id_list не существует'],
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $columnList = new ColumnList([
            'name' => $this->name,
            'id_list' => $this->id_list
        ]);

        return $columnList->save(false);
    }
}
