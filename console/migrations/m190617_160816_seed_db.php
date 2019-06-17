<?php

use yii\db\Migration;

/**
 * Class m190617_160816_seed_db
 */
class m190617_160816_seed_db extends Migration
{
    /**
     * @var string[]
     */
    private $utcOffsets = [];

    /**
     * @var string[]
     */
    private $all2SymbolVariants = [];

    /**
     * @var string[]
     */
    private $all3SymbolVariants = [];


    public function init()
    {
        parent::init();

        $this->utcOffsets = array_merge(
            array_map(
                function($offSet){
                    $offSet = abs($offSet) . ':00';
                    return '-' . str_pad((string)$offSet, 5, '0', STR_PAD_LEFT);
                },
                range(-12, -1)
            ),
            array_map(
                function($offSet){
                    $offSet = str_pad((string)$offSet, 2, '0', STR_PAD_LEFT) . ':00';
                    return '+' . $offSet;
                },
                range(0, 12)
            )
        );

        foreach (range('A', 'Z') as $s1) {
            foreach (range('A', 'Z') as $s2) {

                array_push($this->all2SymbolVariants, $s1 . $s2);

                foreach (range('A', 'Z') as $s3) {
                    array_push($this->all3SymbolVariants, $s1 . $s2 . $s3);
                }
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $faker = \Faker\Factory::create();


        // Airports
        $airportCodes = array_rand(array_flip($this->all3SymbolVariants), 100);
        foreach ($airportCodes as $airportCode) {
            $this->insert(
                '{{%airports}}',
                [
                    'code' => $airportCode,
                    'name' => $faker->country . ' ' . $faker->company,
                    'utc_offset' => array_rand(array_flip($this->utcOffsets)),
                ]
            );
        }


        // Transporters
        $transporterCodes = array_rand(array_flip($this->all2SymbolVariants), 20);
        foreach ($transporterCodes as $transporterCode) {
            $this->insert(
                '{{%transporters}}',
                [
                    'code' => $transporterCode,
                    'name' => $faker->company,
                ]
            );
        }


        // Flights

        $flightCodeSuffixIndexes = array_rand($this->all3SymbolVariants, 899);
        $flightCodePrefixes = array_rand(range(100, 999), 899);
        $flightCodes = [];

        for ($i = 0; $i < 899; $i++) {
            array_push(
                $flightCodes,
                (string)$flightCodePrefixes[$i] . $this->all3SymbolVariants[$flightCodeSuffixIndexes[$i]]
            );

        }

        foreach ($flightCodes as $flightCode) {

            $flightAirports = array_rand($airportCodes, 2);

            $this->insert(
                '{{%flights}}',
                [
                    'number' => $flightCode,
                    'transporter_code' => array_rand(array_flip($transporterCodes)),
                    'departure_airport_code' => $airportCodes[$flightAirports[0]],
                    'arrival_airport_code' => $airportCodes[$flightAirports[1]],
                    'duration' => array_rand(array_flip(range(60, 300, 10))),
                ]
            );
        }


        // Flight Schedule
        $startTime = strtotime('-3 days');
        $endTime = strtotime('+1 month');

        for ($t = $startTime;$t < $endTime; $t += 60 * 5) {

            $this->insert(
                '{{%flight_schedule}}',
                [
                    'flight_number' => $flightCodes[array_rand($flightCodes)],
                    'departure_time' => date('Y-m-d H:i', $t)
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DELETE FROM {{%flight_schedule}}');
        $this->execute('DELETE FROM {{%flights}}');
        $this->execute('DELETE FROM {{%airports}}');
        $this->execute('DELETE FROM {{%transporters}}');
    }
}
