<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\Library\FormUi;

/** @var yii\web\View $this */
/** @var app\models\lot $model */
/** @var yii\widgets\ActiveForm $form */
?>




<!-- Add a grid container for the form -->
<div class="lot-form  p-2 bg-surface rounded-xl shadow-lg shadow-surface/20 grid gap-6 my-8">
    <?php $form = ActiveForm::begin(FormUi::formConfig('lot-form')); ?>

    <?= $form->errorSummary($model, ['class' => 'alert alert-danger']) ?>

    <!-- span 2 cols -->
    <div class="col-span-1 md:col-span-2">


        <?= $form->field($model, 'description', FormUi::fieldConfig()['base'])->textarea(array_merge(FormUi::inputOptions()['textarea'], [
            'rows' => 3,
            'placeholder' => 'e.g. "Q1 2024/2025 Attachment Batch"',
        ])) ?>

    </div>
    <!-- single col for md and 2 cols for lg -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- opening date -->
        <?= $form->field($model, 'opening_date', FormUi::fieldConfig()['base'])->textInput(array_merge(FormUi::inputOptions()['text'], ['type' => 'datetime-local'])) ?>
        <!-- closing date -->
        <?= $form->field($model, 'closing_date', FormUi::fieldConfig()['base'])->textInput(array_merge(FormUi::inputOptions()['text'], ['type' => 'datetime-local'])) ?>

    </div>




    <?= Html::submitButton('Save', [
        'class' => 'w-full py-4 bg-primary text-white font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center justify-center gap-2',
    ]) ?>

</div>
<?php ActiveForm::end(); ?>