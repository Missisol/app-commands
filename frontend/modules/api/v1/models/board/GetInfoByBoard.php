<?php

namespace frontend\modules\api\v1\models\board;

use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\GetInfoByEntity;

class GetInfoByBoard extends ValidationModel implements GetInfoByEntity
{
    private $user_id;

    public $id;

    /**
     * @param int $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function rules()
    {
        return [
            ['id', 'default', 'value' => null],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class,
                 'message' => 'Доски пользователя с данным id не существует', ],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        return $this->id ? $this->getInfoByOneBoard() : $this->getInitInfo();
    }

    private function getInitInfo()
    {
        $boards = Board::findAll([
            'id_user' => $this->user_id,
        ]);

        return [
            'boards' => $boards,
        ];
    }

    private function getInfoByOneBoard()
    {
        $board = Board::findOne($this->id);
        $board->setScenario(Board::SCENARIO_INFO_ABOUT_ONE_BOARD);

        return $board;
    }
}
