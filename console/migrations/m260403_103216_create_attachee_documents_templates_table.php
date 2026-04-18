<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attachee_documents_templates}}`.
 */
class m260403_103216_create_attachee_documents_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachee_documents_templates}}', [
            'id' => $this->primaryKey(),
            'document_description' => $this->string(250),
            'notes' => $this->text(),
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
        $this->dropTable('{{%attachee_documents_templates}}');
    }
}
