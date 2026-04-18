<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AttacheeDocuments $model */

$this->title = Yii::t('app', 'Create Attachee Documents');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachee Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachee-documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
