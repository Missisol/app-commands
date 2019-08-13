<?php

namespace frontend\modules\api\v1\models\entity;

use common\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "board".
 *
 * @property int      $id
 * @property string   $title
 * @property int      $id_user
 * @property int      $created_at
 * @property int      $updated_at
 * @property User     $user
 * @property Column[] $columns
 * @property Label[]  $labels
 */
class Board extends \yii\db\ActiveRecord
{
    const SCENARIO_INFO_ABOUT_ONE_BOARD = 'infoAboutOneBoard';

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
            [['title', 'id_user', 'created_at', 'updated_at'], 'required'],
            [['id_user', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
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
    public function getColumns()
    {
        return $this->hasMany(Column::class, ['id_board' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabels()
    {
        return $this->hasMany(Label::class, ['id_board' => 'id']);
    }

    public function fields()
    {
        if (self::SCENARIO_INFO_ABOUT_ONE_BOARD == $this->scenario) {
            return [
                'id',
                'title',
                'columns',
                'labels',
            ];
        }

        return [
            'id',
            'title'
        ];
    }
}
