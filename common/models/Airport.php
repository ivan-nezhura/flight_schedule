<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Airport".
 *
 * @property string $code
 * @property string $name
 * @property string $utc_offset
 */
class Airport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'airports';
    }

}