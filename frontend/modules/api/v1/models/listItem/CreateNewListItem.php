<?php

namespace frontend\modules\api\v1\models\listItem;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\CreateNewEntity;
use frontend\modules\api\v1\models\entity\ListItem;
use frontend\modules\api\v1\models\entity\ListUser;

class CreateNewListItem extends ValidationModel implements CreateNewEntity
{
    public $title;
    public $id_list;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название пункта задачи не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия пункта задачи - 255 символов.'],

            ['id_list', 'required', 'message' => 'id_list не может быть пустым.'],
            ['id_list', 'integer'],
            [['id_list'], 'exist', 'skipOnError' => true, 'targetClass' => ListUser::class, 'targetAttribute' => ['id_list' => 'id'], 'message' => 'Список с данным id_list не существует'],
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $position = ListItem::find()
            ->where(['id_list' => $this->id_list])
            ->max('position') + ListItem::INCREASE_POSITION;

        $listItem = new ListItem([
            'title' => $this->title,
            'id_list' => $this->id_list,
            'position' => $position,
        ]);

        return $listItem->save(false)
            ? [
                'id' => $listItem->id,
                'position' => $position,
            ]
            : false;
    }
}
