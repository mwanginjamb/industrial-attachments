<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%institution}}`.
 */
class m260608_221639_create_institution_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%institution}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(350),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%institution}}');
    }
}
