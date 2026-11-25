<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\lot $model */

$this->title = 'Create Lot';
$this->params['breadcrumbs'][] = ['label' => 'Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="lot-create">
    <header class="mb-12 border-l-4 border-primary pl-8">

        <h1 class="text-4xl font-extrabold tracking-tight text-primary mt-2">
            <?= Html::encode($this->title) ?>
        </h1>
        <p class="text-on-surface-variant max-w-2xl mt-3 leading-relaxed">

            Create a new lot to set up an application batch with defined opening and closing dates, making it easier to
            track and review student applications within that timeframe.
        </p>
    </header>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>