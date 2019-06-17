<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%flights}}`.
 */
class m190617_140917_create_flights_table extends Migration
{
    const TABLE_FLIGHTS = '{{%flights}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_FLIGHTS, [
            'number' => $this->char(6)->notNull(),
            'transporter_code' => $this->char(2)->notNull(),
            'departure_airport_code' => $this->char(3)->notNull(),
            'arrival_airport_code' => $this->char(3)->notNull(),
            'duration' => $this->smallInteger()->unsigned()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('flights-pk', self::TABLE_FLIGHTS, 'number');

        $this->addForeignKey(
            'flight-transporter_fk',
            self::TABLE_FLIGHTS,
            'transporter_code',
            '{{%transporters}}',
            'code',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'flight-departure_airport_fk',
            self::TABLE_FLIGHTS,
            'departure_airport_code',
            '{{%airports}}',
            'code',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'flight-arrival_airport_fk',
            self::TABLE_FLIGHTS,
            'arrival_airport_code',
            '{{%airports}}',
            'code',
            'RESTRICT',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable(self::TABLE_FLIGHTS);
    }
}
