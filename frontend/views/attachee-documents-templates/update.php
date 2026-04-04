<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AttacheeDocumentsTemplates $model */

$this->title = Yii::t('app', 'Update Attachee Documents Templates: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachee Documents Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="attachee-documents-templates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
