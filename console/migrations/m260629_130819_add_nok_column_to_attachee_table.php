<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%attachee}}`.
 */
class m260629_130819_add_nok_column_to_attachee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attachee}}', 'attachee_phone_number', $this->string(15));
        $this->addColumn('{{%attachee}}', 'email_address', $this->string(150));
        $this->addColumn('{{%attachee}}', 'id_number', $this->string(25));
        $this->addColumn('{{%attachee}}', 'nok_phone_number', $this->string(15));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attachee}}', 'attachee_phone_number');
        $this->dropColumn('{{%attachee}}', 'email_address');
        $this->dropColumn('{{%attachee}}', 'id_number');
        $this->dropColumn('{{%attachee}}', 'nok_phone_number');
    }
}
