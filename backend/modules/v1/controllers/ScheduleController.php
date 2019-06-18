<?php

namespace backend\modules\v1\controllers;

use backend\models\ExtendedFlightSchedule;
use backend\modules\v1\models\ExtendedFlightScheduleSearch;
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

        foreach ($searchQuery as $key => $value) {
            if (!property_exists(ExtendedFlightScheduleSearch::class, $key)) {
                unset($searchQuery[$key]);
            }
        }

        $finalResult['searchQuery'] = $searchQuery;

        $finalResult['searchResults'] = parent::afterAction($action, $result);

        return $finalResult;
    }
}
