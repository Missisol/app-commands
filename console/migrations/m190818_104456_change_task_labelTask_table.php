<?php

use yii\db\Migration;

/**
 * Class m190818_104456_change_task_labelTask_table
 */
class m190818_104456_change_task_labelTask_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%task}}', 'description', $this->text());

        $this->dropColumn('{{%labelTask}}', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%task}}', 'description', $this->string());
        
        $this->addColumn('{{%labelTask}}', 'title', $this->string()->notNull());
    }
}
