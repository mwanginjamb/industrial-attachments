<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Institution $model */

$this->title = Yii::t('app', 'Create Institution');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institutions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
