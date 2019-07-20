<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%board}}`.
 */
class m190720_103954_create_board_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%board}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk_board_user', 
            'board', 
            'user_id', 
            'user', 
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%board}}');
    }
}
