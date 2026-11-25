<?php

namespace frontend\modules\apiv1\controllers;

use frontend\models\Application;
use yii\rest\ActiveController;

class ApplicationController extends ActiveController
{
    public $modelClass = Application::class;
}