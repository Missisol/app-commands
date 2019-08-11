<?php

namespace frontend\modules\api\v1\models\board;

use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateBoard extends ValidationModel implements ActionByEntity
{
    public $id;
    public $title;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id доски не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class,
                'message' => 'Доски с данным id не существует', ],

            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название доски не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'message' => 'Максимальная длина названия задачи - 255 символов.']
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $board = Board::findOne($this->id);
        $board->title = $this->title;

        return $board->save();
    }
}
