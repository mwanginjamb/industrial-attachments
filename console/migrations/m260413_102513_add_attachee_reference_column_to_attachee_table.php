<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%attachee}}`.
 */
class m260413_102513_add_attachee_reference_column_to_attachee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attachee}}', 'attachee_reference', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attachee}}', 'attachee_reference');
    }
}
