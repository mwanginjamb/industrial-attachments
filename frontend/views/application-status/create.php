<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ApplicationStatus $model */

$this->title = Yii::t('app', 'Create Application Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Application Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
