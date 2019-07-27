<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "board".
 *
 * @property int $id
 * @property string $name
 * @property int $id_user
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property ListIssue[] $lists
 * @property TaskTab[] $tasktabs
 */
class Board extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'board';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_user', 'created_at', 'updated_at'], 'required'],
            [['id_user', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'id_user' => 'Id User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLists()
    {
        return $this->hasMany(ListUser::class, ['id_board' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasktabs()
    {
        return $this->hasMany(TaskTab::class, ['id_board' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'name'
        ];
    }
}
