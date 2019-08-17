<?php

namespace frontend\modules\api\v1\models\listUser;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\CreateNewEntity;
use frontend\modules\api\v1\models\entity\Column;

class CreateNewListUser extends ValidationModel implements CreateNewEntity
{
    public $title;
    public $id_column;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название списка задач не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия списка задач - 255 символов.'],

            ['id_column', 'required', 'message' => 'id_column не может быть пустым.'],
            ['id_column', 'integer'],
            [['id_column'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class, 'targetAttribute' => ['id_column' => 'id'], 'message' => 'Колонки с данным id_column не существует']
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $position = ListUser::find()
            ->where(['id_column' => $this->id_column])
            ->max('position') + ListUser::INCREASE_POSITION;

        $listUser = new ListUser([
            'title' => $this->title,
            'position' => $position,
            'id_column' => $this->id_column
        ]);

        return $listUser->save(false) 
            ? [
                'id' => $listUser->id,
                'position' => $position
            ] 
            : false;
    }
}
