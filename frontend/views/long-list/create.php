<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\LongList $model */

$this->title = 'Create Long List';
$this->params['breadcrumbs'][] = ['label' => 'Long Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="long-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
