<?php

namespace backend\controllers;

use backend\models\ExtendedFlightSchedule;
use backend\models\ExtendedFlightScheduleSearch;
use yii\helpers\VarDumper;
use yii\rest\IndexAction;

class ScheduleController extends BaseApiController
{
    public $modelClass = ExtendedFlightSchedule::class;

    public function actions()
    {
        $actions = [
            'search' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => function() {
                    $extendedFlightScheduleSearch = new ExtendedFlightScheduleSearch();

                    return $extendedFlightScheduleSearch->search(\Yii::$app->request->getQueryParams());
                }
            ],
        ];

        return $actions;
    }

    public function afterAction($action, $result)
    {
        $finalResult = [];

        $searchQuery = \Yii::$app->request->get();

        unset($searchQuery['r']);
        unset($searchQuery['expand']);

        $finalResult['searchQuery'] = $searchQuery;

        $finalResult['searchResults'] = parent::afterAction($action, $result);

        return $finalResult;
    }
}
