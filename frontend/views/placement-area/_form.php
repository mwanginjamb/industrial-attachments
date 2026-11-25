<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\PlacementArea $model */
/** @var yii\widgets\ActiveForm $form */

// Shared field config — preserves the "bottom-border only" input aesthetic
$fieldConfig = [
    'template' => "<div class=\"space-y-2\">\n{label}\n{input}\n{error}\n</div>",
    'labelOptions' => ['class' => 'block text-sm font-medium font-label text-on-surface-variant'],
    'errorOptions' => ['class' => 'text-xs text-error mt-1'],
];

// Shared input classes
$inputClass = 'w-full bg-surface-container-lowest border-none border-b-2 border-transparent '
    . 'focus:ring-0 focus:border-primary-container p-3 rounded-t-lg transition-all';
?>

<div class="placement-area-form">

    <?php $form = ActiveForm::begin([
        'id' => 'placement-area-form',
        'options' => ['class' => 'space-y-12'],
        // Suppress Yii's default Bootstrap field wrappers
        'fieldConfig' => $fieldConfig,
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>