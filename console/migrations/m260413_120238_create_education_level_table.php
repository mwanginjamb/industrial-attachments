<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%education_level}}`.
 */
class m260413_120238_create_education_level_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%education_level}}', [
            'id' => $this->primaryKey(),
            'level' => $this->string(),
            'created_at' => $this->integer(30),
            'updated_at' => $this->integer(30),
            'updated_by' => $this->integer(),
            'created_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%education_level}}');
    }
}
