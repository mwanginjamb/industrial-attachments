<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%attachee}}`.
 */
class m260413_101829_add_level_of_education_column_to_attachee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attachee}}', 'level_of_education', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attachee}}', 'level_of_education');
    }
}
