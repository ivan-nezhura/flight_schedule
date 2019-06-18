<?php

namespace backend\modules\v1\controllers;

use common\models\User;
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
                'Access-Control-Request-Headers' => ['*', 'Content-Type'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
                'Access-Control-Allow-Headers' => ['authorization', 'Authorization', 'Content-Type'],
            ]

        ];

        $behaviors['basicAuth'] = [
            'class' => HttpBasicAuth::class,
//            'except' => ['options'],
            'auth' => function($username, $password){
                $user = User::findOne(['username' => $username]);

                return $user && $user->validatePassword($password) ? $user : null;
            }
        ];

        return array_merge(parent::behaviors(), $behaviors);
    }
}