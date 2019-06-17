<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule}}`.
 */
class m190617_140927_create_schedule_table extends Migration
{
    const TABLE_FLIGHT_SCHEDULE = '{{%flight_schedule}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_FLIGHT_SCHEDULE, [
            'id' => $this->primaryKey(),
            'flight_number' => $this->char(6)->notNull(),
            'departure_time' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'flight_fk',
            self::TABLE_FLIGHT_SCHEDULE,
            'flight_number',
            '{{%flights}}',
            'number',
            'RESTRICT',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable(self::TABLE_FLIGHT_SCHEDULE);
    }
}
