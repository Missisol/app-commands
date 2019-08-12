<?php

namespace frontend\modules\api\v1\service;

use common\models\User;
use frontend\modules\api\v1\models\entity\Board;

class InitBoardUser
{
    private const NAME_FIRST_BOARD_USER = 'Личная доска';

    /**
     * Create first board of user
     *
     * @param User $user
     * @return bool whether creation is successfully.
     */
    public static function initBoard($user)
    {
        $board = new Board([
            'title' => self::NAME_FIRST_BOARD_USER,
            'id_user' => $user->id
        ]);
        return $board->save(false);
    }
}
