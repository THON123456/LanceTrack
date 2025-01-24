<?php

use yii\db\Migration;

class m240727_123456_update_notification_table extends Migration
{
    public function up()
    {
        // Ubah kolom url menjadi nullable
        $this->alterColumn('{{%notification}}', 'url', $this->string()->null());
    }

    public function down()
    {
        // Kembalikan kolom url ke keadaan semula (non-nullable)
        $this->alterColumn('{{%notification}}', 'url', $this->string()->notNull());
    }
}
