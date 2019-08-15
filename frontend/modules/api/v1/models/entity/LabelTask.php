<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "labelTask".
 *
 * @property int $id
 * @property string $title
 * @property int $id_task
 * @property int $id_label
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Label $label
 * @property Task $task
 */
class LabelTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'labelTask';
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
            [['title', 'id_task', 'id_label', 'created_at', 'updated_at'], 'required'],
            [['id_task', 'id_label', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id_label'], 'exist', 'skipOnError' => true, 'targetClass' => Label::className(), 'targetAttribute' => ['id_label' => 'id']],
            [['id_task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['id_task' => 'id']],
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
            'id_task' => 'Id Task',
            'id_label' => 'Id Label',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(Label::className(), ['id' => 'id_label']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'id_task']);
    }

    public function fields()
    {
        return [
            'id',
            'title'
        ];
    }
}
