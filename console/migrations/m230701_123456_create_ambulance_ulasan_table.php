<?php

use yii\db\Migration;

class m230701_123456_create_ambulance_ulasan_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('ambulance_ulasan', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->notNull(),
            'review' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-ambulance_ulasan-user_id',
            'ambulance_ulasan',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-ambulance_ulasan-user_id', 'ambulance_ulasan');
        $this->dropTable('ambulance_ulasan');
    }
}
