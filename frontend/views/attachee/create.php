<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Attachee $model */

$this->title = Yii::t('app', 'Create Attachee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fileModel' => new \frontend\models\File(),
        'docTemplates' => $templates,
    ]) ?>

</div>