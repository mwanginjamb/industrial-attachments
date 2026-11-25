<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%institution}}`.
 *
 * Duplicate of m260522_095620_create_institution_table (introduced by a branch
 * merge). Guarded so fresh databases don't fail when the earlier migration has
 * already created the table; the earlier migration owns the drop on rollback.
 */
class m260608_221639_create_institution_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%institution}}', true) !== null) {
            echo "    > table {{%institution}} already exists, skipping.\n";
            return;
        }

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
        // No-op: m260522_095620_create_institution_table drops the table.
    }
}
