<?php

namespace backend\components;

use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class Request extends \yii\web\Request
{
    public function resolve()
    {
        try {
            return parent::resolve();
        } catch (NotFoundHttpException $e) {
            throw new BadRequestHttpException();
        }
    }
}
