<?php

use yii\db\Migration;

class m210101_000000_add_latitude_longitude_columns_to_ambulance_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%ambulance}}', 'latitude', $this->decimal(10, 8)->notNull()->defaultValue(0));
        $this->addColumn('{{%ambulance}}', 'longitude', $this->decimal(11, 8)->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ambulance}}', 'latitude');
        $this->dropColumn('{{%ambulance}}', 'longitude');
    }
}
