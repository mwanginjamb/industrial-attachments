<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%attachee}}`.
 */
class m260429_191207_add_placement_n_uni_column_to_attachee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attachee}}', 'institution_id', $this->integer());
        $this->addColumn('{{%attachee}}', 'preferred_placement_designation', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attachee}}', 'institution_id');
        $this->dropColumn('{{%attachee}}', 'preferred_placement_designation');
    }
}
