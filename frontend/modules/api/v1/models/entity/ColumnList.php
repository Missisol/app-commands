<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "columnlist".
 *
 * @property int $id
 * @property string $name
 * @property int $id_list
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ListUser $list
 * @property ListIssue[] $listissues
 */
class ColumnList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'columnlist';
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
            [['name', 'id_list', 'created_at', 'updated_at'], 'required'],
            [['id_list', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_list'], 'exist', 'skipOnError' => true, 'targetClass' => ListUser::class, 'targetAttribute' => ['id_list' => 'id']],
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
            'id_list' => 'Id List',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(ListUser::class, ['id' => 'id_list']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListissues()
    {
        return $this->hasMany(ListIssue::class, ['id_columnList' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'listIssues' => 'listissues'
        ];
    }
}
