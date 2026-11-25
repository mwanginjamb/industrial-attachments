<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\LongList $model */

$this->title = 'Update Long List: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Long Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="long-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
