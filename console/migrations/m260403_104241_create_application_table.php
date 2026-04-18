<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%lot}}`
 * - `{{%attachee}}`
 * - `{{%application_status}}`
 */
class m260403_104241_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'lot_id' => $this->integer(),
            'attachee_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(25),
            'updated_by' => $this->integer(25),
        ]);

        // creates index for column `lot_id`
        $this->createIndex(
            '{{%idx-application-lot_id}}',
            '{{%application}}',
            'lot_id'
        );

        // add foreign key for table `{{%lot}}`
        $this->addForeignKey(
            '{{%fk-application-lot_id}}',
            '{{%application}}',
            'lot_id',
            '{{%lot}}',
            'id',
            'CASCADE'
        );

        // creates index for column `attachee_id`
        $this->createIndex(
            '{{%idx-application-attachee_id}}',
            '{{%application}}',
            'attachee_id'
        );

        // add foreign key for table `{{%attachee}}`
        $this->addForeignKey(
            '{{%fk-application-attachee_id}}',
            '{{%application}}',
            'attachee_id',
            '{{%attachee}}',
            'id',
            'CASCADE'
        );

        // creates index for column `status`
        $this->createIndex(
            '{{%idx-application-status}}',
            '{{%application}}',
            'status'
        );

        // add foreign key for table `{{%application_status}}`
        $this->addForeignKey(
            '{{%fk-application-status}}',
            '{{%application}}',
            'status',
            '{{%application_status}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%lot}}`
        $this->dropForeignKey(
            '{{%fk-application-lot_id}}',
            '{{%application}}'
        );

        // drops index for column `lot_id`
        $this->dropIndex(
            '{{%idx-application-lot_id}}',
            '{{%application}}'
        );

        // drops foreign key for table `{{%attachee}}`
        $this->dropForeignKey(
            '{{%fk-application-attachee_id}}',
            '{{%application}}'
        );

        // drops index for column `attachee_id`
        $this->dropIndex(
            '{{%idx-application-attachee_id}}',
            '{{%application}}'
        );

        // drops foreign key for table `{{%application_status}}`
        $this->dropForeignKey(
            '{{%fk-application-status}}',
            '{{%application}}'
        );

        // drops index for column `status`
        $this->dropIndex(
            '{{%idx-application-status}}',
            '{{%application}}'
        );

        $this->dropTable('{{%application}}');
    }
}
