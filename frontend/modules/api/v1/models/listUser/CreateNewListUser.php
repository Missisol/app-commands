<?php

namespace frontend\modules\api\v1\models\listUser;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\CreateNewEntity;

class CreateNewListUser extends ValidationModel implements CreateNewEntity
{
    public $name;
    public $id_board;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required', 'message' => 'Название списка задач пользователя не может быть пустым.'],
            ['name', 'string', 'max' => 255, 
                'tooLong' => 'Максимальная длина названия списка задач пользователя - 255 символов.'],

            ['id_board', 'required', 'message' => 'id_board не может быть пустым.'],
            ['id_board', 'integer'],
            [['id_board'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class, 'targetAttribute' => ['id_board' => 'id'], 'message' => 'Доски с данным id_board не существует']
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $listUser = new ListUser([
            'name' => $this->name,
            'id_board' => $this->id_board
        ]);

        return $listUser->save(false);
    }
}
