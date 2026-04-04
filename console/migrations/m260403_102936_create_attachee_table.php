<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attachee}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m260403_102936_create_attachee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachee}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(150),
            'year_of_study' => $this->string(20),
            'course_name' => $this->string(250),
            'expected_completion_date' => $this->date(),
            'area_of_interest' => $this->text(),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(25),
            'updated_by' => $this->integer(25),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-attachee-user_id}}',
            '{{%attachee}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-attachee-user_id}}',
            '{{%attachee}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-attachee-user_id}}',
            '{{%attachee}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-attachee-user_id}}',
            '{{%attachee}}'
        );

        $this->dropTable('{{%attachee}}');
    }
}
