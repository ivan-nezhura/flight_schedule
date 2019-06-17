<?php

namespace backend\components;

use yii\web\HttpException;

class InvalidRequestHttpException extends HttpException
{
    /**
     * InvalidRequestHttpException constructor.
     * @param null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(422, $message, $code, $previous);
    }
}
