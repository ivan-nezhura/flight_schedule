<?php

use yii\db\Migration;

/**
 * Class m190617_154109_create_extended_schedule_view
 */
class m190617_154109_create_extended_schedule_view extends Migration
{
    const VIEW_NAME = '{{%ext_flight_schedule_v}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $createViewSql = '
        CREATE VIEW '. self::VIEW_NAME . '
        AS
        SELECT
            f.transporter_code,
            fs.flight_number AS flightNumber,
            d.code AS departureAirport,
            a.code AS arrivalAirport,
            fs.departure_time AS departureDateTime,
            CONVERT_TZ(DATE_ADD(fs.departure_time, INTERVAL f.duration MINUTE), d.utc_offset, a.utc_offset) AS arrivalDateTime,
            f.duration
        FROM flight_schedule fs
        LEFT JOIN flights f ON fs.flight_number = f.number
        LEFT JOIN airports a ON f.arrival_airport_code = a.code
        LEFT JOIN airports d ON f.departure_airport_code = d.code
        ';

        $this->execute($createViewSql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $dropViewSql = 'DROP VIEW ' . self::VIEW_NAME;

        $this->execute($dropViewSql);
    }
}
