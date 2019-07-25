<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "listissue".
 *
 * @property int $id
 * @property string $name
 * @property int $id_columnList
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Issue[] $issues
 * @property ColumnList $columnList
 */
class ListIssue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listissue';
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
            [['name', 'id_columnList', 'created_at', 'updated_at'], 'required'],
            [['id_columnList', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_columnList'], 'exist', 'skipOnError' => true, 'targetClass' => ColumnList::class, 'targetAttribute' => ['id_columnList' => 'id']],
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
            'id_columnList' => 'Id Column List',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issue::class, ['id_listIssue' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumnList()
    {
        return $this->hasOne(ColumnList::class, ['id' => 'id_columnList']);
    }
}
