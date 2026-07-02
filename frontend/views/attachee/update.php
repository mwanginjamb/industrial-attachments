<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Attachee $model */

$this->title = Yii::t('app', 'Update Attachee: {name} - {reference}', [
    'name' => $model->name,
    'reference' => $model->attachee_reference ?? 'Not Set',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="attachee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'file' => $fileModel,
        'templates' => $docTemplates,
        'institutions' => $institutions,
    ]) ?>

</div>