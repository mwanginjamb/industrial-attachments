<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%application}}`.
 */
class m260521_173504_add_review_column_to_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%application}}', 'placement', $this->integer());
        $this->addColumn('{{%application}}', 'closed', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%application}}', 'placement');
        $this->dropColumn('{{%application}}', 'closed');
    }
}
