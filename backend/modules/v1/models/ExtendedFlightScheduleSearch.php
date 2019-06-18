<?php

namespace backend\modules\v1\models;

use backend\components\InvalidRequestHttpException;
use backend\models\ExtendedFlightSchedule;
use common\models\Airport;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;


class ExtendedFlightScheduleSearch extends Model
{
    public $departureAirport;
    public $arrivalAirport;
    public $departureDate;

    const WRONG_AIRPORT_ERR_MESSAGE = 'Wrong airport';
    const WRONG_DATE_ERR_MESSAGE = 'Wrong date';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['departureAirport', 'arrivalAirport'],
                'required',
                'message' => self::WRONG_AIRPORT_ERR_MESSAGE
            ],

            [
                ['departureDate'],
                'required',
                'message' => self::WRONG_DATE_ERR_MESSAGE
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
     * @throws HttpException
     */
    public function search($params)
    {
        $query = ExtendedFlightSchedule::find();

        $query->orderBy(['arrivalDateTime' => SORT_ASC]);

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

        if ((int)$query->count() === 0) {
            throw new NotFoundHttpException('No flights found');
        }


        return $dataProvider;
    }

}