<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%attachee}}`.
 */
class m260702_111202_add_other_institution_name_column_to_attachee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attachee}}', 'other_institution_name', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attachee}}', 'other_institution_name');
    }
}
