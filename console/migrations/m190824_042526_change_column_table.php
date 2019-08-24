<?php

use yii\db\Migration;

/**
 * Class m190824_042526_change_column_table
 */
class m190824_042526_change_column_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%column}}', 'position', $this->integer()->notNull());

        $this->dropIndex('ix_user_password_reset_token', '{{%user}}');
        $this->dropIndex('ix_user_status', '{{%user}}');
        $this->dropIndex('ix_user_verification_token', '{{%user}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%column}}', 'position');

        $this->createIndex('ix_user_password_reset_token', '{{%user}}', 'password_reset_token');
        $this->createIndex('ix_user_status', '{{%user}}', 'status');
        $this->createIndex('ix_user_verification_token', '{{%user}}', 'verification_token');
    }
}
