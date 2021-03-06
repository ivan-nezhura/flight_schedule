<?php

namespace backend\components;

use Yii;
use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler
{
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            // reset parameters of response to avoid interference with partially created response data
            // in case the error occurred while sending the response.
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $response->setStatusCodeByException($exception);

        $response->format = Response::FORMAT_JSON;
        $response->data = $this->convertExceptionToArray($exception);

        $response->send();
    }
}
