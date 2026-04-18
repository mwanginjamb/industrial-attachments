<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**********
 * @var $file frontend\models\AttacheeDocuments
 * @var $t frontend\models\AttacheeDocumentsTemplates
 * @var $model frontend\models\Attachees
 */

?>
<!-- inline upload form -->
<?php $form = ActiveForm::begin(['id' => 'national-id-form', 'options' => ['name' => $file->formName()]]); ?>

<?= $form->field($file, 'attachee_id')->hiddenInput(['value' => $model->attachee_reference])->label(false) ?>
<?= $form->field($file, 'document_type')->hiddenInput(['value' => $t['id']])->label(false) ?>
<?= $form->field($file, 'attachment', [
    'template' => '{input}{error}',
    'errorOptions' => ['class' => 'text-xs text-error mt-1 text-right'],
])->fileInput([
            'id' => 'national-id-input',
            'class' => 'hidden',
        ])->label(false) ?>
<label for="national-id-input"
    class="inline-block px-4 py-2 bg-primary-container text-on-primary-container rounded-lg font-bold text-xs shadow-sm hover:shadow-md transition-all cursor-pointer">
    <?= isset($labelIcon) ? $labelIcon . ' ' : 'Upload Now' ?>
</label>
<?php ActiveForm::end(); ?>

<!-- end inline upload form -->