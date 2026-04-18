<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\lot $model */

$this->title = 'Create Lot';
$this->params['breadcrumbs'][] = ['label' => 'Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lot-create min-h-screen flex flex-col md:flex-row">

<section class="w-full min-h-screen flex justify-center p-2 md:p-4 bg-surface">
    <div class="w-full max-w-md">
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-on-surface mb-2"><?= Html::encode($this->title) ?></h1>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</section>
</div>
