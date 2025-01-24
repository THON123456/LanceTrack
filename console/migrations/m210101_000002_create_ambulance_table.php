<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ambulance`.
 */
class m210101_000002_create_ambulance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ambulance', [
            'id' => $this->primaryKey(),
            'tipe' => $this->string(100)->notNull(),
            'plat_nomor' => $this->string(100)->notNull(),
            'nama' => $this->string(100)->notNull(),
            'status' => $this->integer()->notNull(),
            'latitude' => $this->integer(),
            'longitude' => $this->float(),
            'foto' => $this->string()->notNull(),
            'img_url' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ambulance');
    }
}
