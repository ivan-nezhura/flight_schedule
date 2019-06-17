<?php

namespace backend\models;

use backend\components\InvalidRequestHttpException;
use common\models\Airport;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;


class ExtendedFlightScheduleSearch extends Model
{
    public $departureAirport;
    public $arrivalAirport;
    public $departureDate;

    const BAD_REQUEST_ERR_MESSAGE = 'bad request';
    const WRONG_AIRPORT_ERR_MESSAGE = 'Wrong airport';
    const WRONG_DATE_ERR_MESSAGE = 'Wrong date';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['departureAirport', 'departureAirport', 'arrivalAirport'],
                'required',
                'message' => self::BAD_REQUEST_ERR_MESSAGE
            ],

            [
                ['departureAirport', 'arrivalAirport'],
                'string',
                'min' => 3,
                'max' => 3,
                'message' => self::WRONG_AIRPORT_ERR_MESSAGE
            ],

            [
                ['departureAirport', 'arrivalAirport'],
                'exist',
                'targetClass' => Airport::class,
                'targetAttribute' => 'code',
                'message' => self::WRONG_AIRPORT_ERR_MESSAGE
            ],

            [
                'departureAirport',
                'compare',
                'operator' => '!==',
                'compareAttribute' => 'arrivalAirport',
                'message' => self::WRONG_AIRPORT_ERR_MESSAGE
            ],

            [
                'departureDate',
                'date',
                'format' => 'php:Y-m-d',
                'message' => self::WRONG_DATE_ERR_MESSAGE
            ],

            [
                'departureDate',
                'compare',
                'operator' => '>=',
                'compareValue' => date('Y-m-d'),
                'message' => self::WRONG_DATE_ERR_MESSAGE
            ]
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws InvalidRequestHttpException
     */
    public function search($params)
    {
        $query = ExtendedFlightSchedule::find();

        $query->orderBy(['arrivalDateTime' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            throw new InvalidRequestHttpException(current($this->firstErrors));
        }

        $query->andFilterWhere([
            'arrivalAirport' => $this->arrivalAirport,
            'departureAirport' => $this->departureAirport,
        ]);

        $query->andWhere(new Expression('DATE(`departureDateTime`) = :date', ['date' => $this->departureDate]));

        if ($query->count() === 0) {
            throw new InvalidRequestHttpException('Empty result');
        }


        return $dataProvider;
    }

}