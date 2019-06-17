<?php
namespace frontend\controllers;

use yii\db\Query;
use yii\helpers\Html;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->registerJsVar(
            'airports',
            (new Query())->from('{{%airports}}')->all()
        );

        return $this->renderContent(Html::tag('div', '', ['id' => 'app-root']));
    }
}
