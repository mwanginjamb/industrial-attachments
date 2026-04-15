<?php

use yii\db\Migration;

class m260415_133226_alter_attachee_id_in_attachee_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        //$this->dropForeignKey('{{%fk-attachee_documents-attachee_id}}', '{{%attachee_documents}}');
        $this->alterColumn('{{%attachee_documents}}', 'attachee_id', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%attachee_documents}}', 'attachee_id', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260415_133226_alter_attachee_id_in_attachee_documents_table cannot be reverted.\n";

        return false;
    }
    */
}
