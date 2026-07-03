<?php

use yii\db\Migration;

class m260629_131544_add_selections_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260629_131544_add_selections_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260629_131544_add_selections_table cannot be reverted.\n";

        return false;
    }
    */
}
