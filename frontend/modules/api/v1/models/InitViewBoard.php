<?php

namespace frontend\modules\api\v1\models;

use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\entity\TaskTab;
use frontend\modules\api\v1\models\entity\ListUser;

class InitViewBoard
{
    private $user_id;

    /**
     * @param integer $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function initView()
    {
        $boards = Board::findAll([
            'id_user' => $this->user_id,
        ]);

        $taskTabs = [];
        $lists = [];

        if (count($boards) >= 1) {
            $idBoard = $boards[0]->id;
            $taskTabs = TaskTab::findAll([
                'id_board' => $idBoard,
            ]);
            $lists = ListUser::findAll([
                'id_board' => $idBoard,
            ]);
        }

        return [
            'boards' => $boards,
            'taskTabs' => $taskTabs,
            'lists' => $lists
        ];
    }
}
