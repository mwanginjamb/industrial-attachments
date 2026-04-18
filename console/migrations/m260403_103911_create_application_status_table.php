<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application_status}}`.
 */
class m260403_103911_create_application_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application_status}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(50),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(25),
            'updated_by' => $this->integer(25),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application_status}}');
    }
}
