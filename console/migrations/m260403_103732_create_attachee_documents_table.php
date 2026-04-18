<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attachee_documents}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%attachee}}`
 * - `{{%attachee_documents_templates}}`
 */
class m260403_103732_create_attachee_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachee_documents}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(250),
            'attachee_id' => $this->integer(),
            'document_type' => $this->integer(),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(25),
            'updated_by' => $this->integer(25),
        ]);

        // creates index for column `attachee_id`
        $this->createIndex(
            '{{%idx-attachee_documents-attachee_id}}',
            '{{%attachee_documents}}',
            'attachee_id'
        );

        // add foreign key for table `{{%attachee}}`
        $this->addForeignKey(
            '{{%fk-attachee_documents-attachee_id}}',
            '{{%attachee_documents}}',
            'attachee_id',
            '{{%attachee}}',
            'id',
            'CASCADE'
        );

        // creates index for column `document_type`
        $this->createIndex(
            '{{%idx-attachee_documents-document_type}}',
            '{{%attachee_documents}}',
            'document_type'
        );

        // add foreign key for table `{{%attachee_documents_templates}}`
        $this->addForeignKey(
            '{{%fk-attachee_documents-document_type}}',
            '{{%attachee_documents}}',
            'document_type',
            '{{%attachee_documents_templates}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%attachee}}`
        $this->dropForeignKey(
            '{{%fk-attachee_documents-attachee_id}}',
            '{{%attachee_documents}}'
        );

        // drops index for column `attachee_id`
        $this->dropIndex(
            '{{%idx-attachee_documents-attachee_id}}',
            '{{%attachee_documents}}'
        );

        // drops foreign key for table `{{%attachee_documents_templates}}`
        $this->dropForeignKey(
            '{{%fk-attachee_documents-document_type}}',
            '{{%attachee_documents}}'
        );

        // drops index for column `document_type`
        $this->dropIndex(
            '{{%idx-attachee_documents-document_type}}',
            '{{%attachee_documents}}'
        );

        $this->dropTable('{{%attachee_documents}}');
    }
}
