<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "issue".
 *
 * @property int $id
 * @property string $description
 * @property int $execution
 * @property int $id_listIssue
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ListIssue $listIssue
 */
class Issue extends \yii\db\ActiveRecord
{
    const NO_EXECUTION = 0;
    const EXECUTION = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue';
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
            [['description', 'id_listIssue', 'created_at', 'updated_at'], 'required'],
            [['execution', 'id_listIssue', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['id_listIssue'], 'exist', 'skipOnError' => true, 'targetClass' => ListIssue::class, 'targetAttribute' => ['id_listIssue' => 'id']],

            ['execution', 'default', 'value' => self::NO_EXECUTION],
            ['execution', 'in', 'range' => [self::NO_EXECUTION, self::EXECUTION]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'execution' => 'Execution',
            'id_listIssue' => 'Id List Issue',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListIssue()
    {
        return $this->hasOne(ListIssue::class, ['id' => 'id_listIssue']);
    }

    public function fields()
    {
        return [
            'id',
            'description',
            'execution'
        ];
    }
}
