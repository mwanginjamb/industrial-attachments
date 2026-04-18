<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\lot $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lot-form">

    <?php $form = ActiveForm::begin(
        [
            'options' => ['class' => 'space-y-6'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"relative group\">{input}</div>\n{error}",
                'labelOptions' => ['class' => 'block font-label text-sm font-semibold text-on-surface-variant'],
                'inputOptions' => ['class' => 'w-full pl-12 pr-4 py-3.5 bg-white border ring-1 ring-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all'],
            ],
        ]
    ); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'opening_date')->textInput(['type' => 'datetime-local']) ?>

    <?= $form->field($model, 'closing_date')->textInput(['type' => 'datetime-local']) ?>

    

    
        <?= Html::submitButton('Save', [
            'class' => 'w-full py-4 bg-primary text-white font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center justify-center gap-2',
            ]) ?>
   

    <?php ActiveForm::end(); ?>

</div>
