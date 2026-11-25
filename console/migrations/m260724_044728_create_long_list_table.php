<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%long_list}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%lot}}`
 */
class m260724_044728_create_long_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%long_list}}', [
            'id' => $this->primaryKey(),
            'lot_id' => $this->integer(),
            'description' => $this->text(),
            'status' => $this->string()->defaultValue('OPEN'),
            'created_at' => $this->integer(26),
            'updated_at' => $this->integer(26),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `lot_id`
        $this->createIndex(
            '{{%idx-long_list-lot_id}}',
            '{{%long_list}}',
            'lot_id'
        );

        // add foreign key for table `{{%lot}}`
        $this->addForeignKey(
            '{{%fk-long_list-lot_id}}',
            '{{%long_list}}',
            'lot_id',
            '{{%lot}}',
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
            '{{%fk-long_list-lot_id}}',
            '{{%long_list}}'
        );

        // drops index for column `lot_id`
        $this->dropIndex(
            '{{%idx-long_list-lot_id}}',
            '{{%long_list}}'
        );

        $this->dropTable('{{%long_list}}');
    }
}
