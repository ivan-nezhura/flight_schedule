<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%airports}}`.
 */
class m190617_140853_create_airports_table extends Migration
{
    const TABLE_AIRPORTS = '{{%airports}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_AIRPORTS, [
            'code' => $this->char(3)->notNull(),
            'name' => $this->string(255)->notNull(),
            'utc_offset' => $this->char(6)->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('airports-pk', self::TABLE_AIRPORTS, 'code');
    }

    public function down()
    {
        $this->dropTable(self::TABLE_AIRPORTS);
    }
}
