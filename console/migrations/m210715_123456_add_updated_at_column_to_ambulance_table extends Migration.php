<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ambulance}}`.
 */
class m210715_123456_add_updated_at_column_to_ambulance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ambulance}}', 'updated_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ambulance}}', 'updated_at');
    }
}

