<?php

namespace frontend\modules\apiv1\controllers;

use frontend\models\LongListApplication;
use yii\rest\ActiveController;

class LongListApplicationController extends ActiveController
{
    public $modelClass = LongListApplication::class;
}