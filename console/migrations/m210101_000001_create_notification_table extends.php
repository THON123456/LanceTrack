<?php

use yii\db\Migration;

class m210101_000001_create_notification_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'is_read' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-notification-user_id',
            '{{%notification}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-notification-user_id', '{{%notification}}');
        $this->dropTable('{{%notification}}');
    }
}
