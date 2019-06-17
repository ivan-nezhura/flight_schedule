<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transporters}}`.
 */
class m190617_140906_create_transporters_table extends Migration
{
    const TABLE_TRANSPORTERS = '{{%transporters}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_TRANSPORTERS, [
            'code' => $this->char(2)->notNull(),
            'name' => $this->string(255)->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('transporters-pk', self::TABLE_TRANSPORTERS, 'code');

    }

    public function down()
    {
        $this->dropTable(self::TABLE_TRANSPORTERS);
    }
}
