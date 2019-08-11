<?php

namespace frontend\modules\api\v1\models\board;

use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class CreateNewBoard extends ValidationModel implements ActionByEntity
{
    public $title;

    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название доски не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия доски - 255 символов.'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $board = new Board([
            'title' => $this->title,
            'id_user' => $this->user_id
        ]);

        return $board->save(false);
    }
}
