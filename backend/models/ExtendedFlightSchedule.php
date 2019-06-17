<?php

namespace backend\models;

use common\models\Transporter;
use Yii;

/**
 * This is the model class for table "ext_flight_schedule_v".
 *
 * @property string $transporter_code
 * @property string $flightNumber
 * @property string $departureAirport
 * @property string $arrivalAirport
 * @property string $departureDateTime
 * @property string $arrivalDateTime
 * @property int $duration
 */
class ExtendedFlightSchedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ext_flight_schedule_v';
    }

    public function extraFields()
    {
        return [
            'transporter'
        ];
    }

    public function getTransporter()
    {
        return $this->hasOne(Transporter::class, ['code' => 'transporter_code']);
    }
}