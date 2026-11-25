<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%long_list}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%placement_area}}`
 */
class m260724_093717_add_placement_id_column_to_long_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%long_list}}', 'placement_id', $this->integer());

        // creates index for column `placement_id`
        $this->createIndex(
            '{{%idx-long_list-placement_id}}',
            '{{%long_list}}',
            'placement_id'
        );

        // add foreign key for table `{{%placement_area}}`
        $this->addForeignKey(
            '{{%fk-long_list-placement_id}}',
            '{{%long_list}}',
            'placement_id',
            '{{%placement_area}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%placement_area}}`
        $this->dropForeignKey(
            '{{%fk-long_list-placement_id}}',
            '{{%long_list}}'
        );

        // drops index for column `placement_id`
        $this->dropIndex(
            '{{%idx-long_list-placement_id}}',
            '{{%long_list}}'
        );

        $this->dropColumn('{{%long_list}}', 'placement_id');
    }
}
