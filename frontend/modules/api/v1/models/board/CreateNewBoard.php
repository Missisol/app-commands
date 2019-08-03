<?php

namespace frontend\modules\api\v1\models\board;

use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class CreateNewBoard extends ValidationModel implements ActionByEntity
{
    public $name;

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
            ['name', 'trim'],
            ['name', 'required', 'message' => 'Название доски не может быть пустым.'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия доски - 255 символов.'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $board = new Board([
            'name' => $this->name,
            'id_user' => $this->user_id
        ]);

        return $board->save(false);
    }
}
