<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AttacheeDocumentsTemplates $model */

$this->title = Yii::t('app', 'Create Attachee Documents Templates');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachee Documents Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachee-documents-templates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
