<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lot}}`.
 */
class m260403_100539_create_lot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lot}}', [
            'id' => $this->primaryKey(),
            'description' => $this->text(),
            'opening_date' => $this->dateTime(),
            'closing_date' => $this->dateTime(),
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
        $this->dropTable('{{%lot}}');
    }
}
