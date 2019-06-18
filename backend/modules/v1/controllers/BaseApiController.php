<?php

namespace backend\modules\v1\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class BaseApiController extends ActiveController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ]

        ];

        /*$behaviors['basicAuth'] = [
            'class' => HttpBasicAuth::class,
        ];*/

        return array_merge(parent::behaviors(), $behaviors);
    }
}