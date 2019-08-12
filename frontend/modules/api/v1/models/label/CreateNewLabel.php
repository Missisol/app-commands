<?php

namespace frontend\modules\api\v1\models\label;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\Label;
use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\ActionByEntity;

class CreateNewLabel extends ValidationModel implements ActionByEntity
{
    public $title;
    public $id_board;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название ярлыка не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия ярлыка - 255 символов.'],

            ['id_board', 'required', 'message' => 'id_board не может быть пустым.'],
            ['id_board', 'integer'],
            [['id_board'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class, 'targetAttribute' => ['id_board' => 'id'], 'message' => 'Доски пользователя с данным id_board не существует'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $label = new Label([
            'title' => $this->title,
            'id_board' => $this->id_board
        ]);

        return $label->save(false);
    }
}
