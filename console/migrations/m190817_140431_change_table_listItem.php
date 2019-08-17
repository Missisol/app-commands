<?php

use yii\db\Migration;

/**
 * Class m190817_140431_change_table_listItem
 */
class m190817_140431_change_table_listItem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%listItem}}', 'execution', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%listItem}}', 'execution', $this->integer()->notNull());
    }
}
