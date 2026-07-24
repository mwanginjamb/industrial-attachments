<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%long_list_application}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%long_list}}`
 * - `{{%application}}`
 */
class m260724_045851_create_long_list_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%long_list_application}}', [
            'id' => $this->primaryKey(),
            'long_list_id' => $this->integer(),
            'application_id' => $this->integer(),
            'shortlisted' => $this->boolean()->defaultValue(false),
            'remarks' => $this->text(),
            'created_at' => $this->integer(26),
            'updated_at' => $this->integer(26),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `long_list_id`
        $this->createIndex(
            '{{%idx-long_list_application-long_list_id}}',
            '{{%long_list_application}}',
            'long_list_id'
        );

        // add foreign key for table `{{%long_list}}`
        $this->addForeignKey(
            '{{%fk-long_list_application-long_list_id}}',
            '{{%long_list_application}}',
            'long_list_id',
            '{{%long_list}}',
            'id',
            'CASCADE'
        );

        // creates index for column `application_id`
        $this->createIndex(
            '{{%idx-long_list_application-application_id}}',
            '{{%long_list_application}}',
            'application_id'
        );

        // add foreign key for table `{{%application}}`
        $this->addForeignKey(
            '{{%fk-long_list_application-application_id}}',
            '{{%long_list_application}}',
            'application_id',
            '{{%application}}',
            'id',
            'CASCADE'
        );

        // composite key:
        $this->createIndex(
            'uq-long_list_application',
            '{{%long_list_application}}',
            ['long_list_id', 'application_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%long_list}}`
        $this->dropForeignKey(
            '{{%fk-long_list_application-long_list_id}}',
            '{{%long_list_application}}'
        );

        // drops index for column `long_list_id`
        $this->dropIndex(
            '{{%idx-long_list_application-long_list_id}}',
            '{{%long_list_application}}'
        );

        // drops foreign key for table `{{%application}}`
        $this->dropForeignKey(
            '{{%fk-long_list_application-application_id}}',
            '{{%long_list_application}}'
        );

        // drops index for column `application_id`
        $this->dropIndex(
            '{{%idx-long_list_application-application_id}}',
            '{{%long_list_application}}'
        );

        $this->dropTable('{{%long_list_application}}');
    }
}
