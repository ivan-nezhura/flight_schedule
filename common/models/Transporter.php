<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Transporter".
 *
 * @property string $code
 * @property string $name
 */
class Transporter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transporters';
    }

}