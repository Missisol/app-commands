<?php

use yii\db\Migration;

/**
 * Class m190721_191623_change_user_table
 */
class m190721_191623_change_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'new_email', $this->string()->defaultValue(null));
        $this->addColumn('{{%user}}', 'verify_new_email_token', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'verify_new_email_token');
        $this->dropColumn('{{%user}}', 'new_email');
    }
}
