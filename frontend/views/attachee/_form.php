<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Attachee $model */
/** @var yii\widgets\ActiveForm $form */


/* @var $this yii\web\View */
/* @var $model app\models\attachee */

// Shared field config — preserves the "bottom-border only" input aesthetic
$fieldConfig = [
    'template' => "<div class=\"space-y-2\">\n{label}\n{input}\n{error}\n</div>",
    'labelOptions' => ['class' => 'block text-sm font-medium font-label text-on-surface-variant'],
    'errorOptions' => ['class' => 'text-xs text-error mt-1'],
];

// Shared input classes
$inputClass = 'w-full bg-surface-container-lowest border-none border-b-2 border-transparent '
    . 'focus:ring-0 focus:border-primary-container p-3 rounded-t-lg transition-all';



// Yii::$app->utility->printrr($templates);
?>

<div class="attachee-form">

    <?php $form = ActiveForm::begin([
        'id' => 'profile-editor-form',
        'options' => ['class' => 'space-y-12'],
        // Suppress Yii's default Bootstrap field wrappers
        'fieldConfig' => $fieldConfig,
    ]); ?>

    <!-- Error summary -->
    <?= $form->errorSummary($model) ?>

    <!-- ═══════════════════════════════════════════════════════
     Section 1: Personal & Academic Information
     ═══════════════════════════════════════════════════════ -->

    <section class="bg-surface-container-low rounded-xl p-8 space-y-8">

        <div class="flex items-center gap-4 mb-2">
            <div class="w-10 h-10 rounded-full bg-primary-container/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary-container">school</span>
            </div>
            <h2 class="font-headline font-bold text-2xl text-on-surface">Personal &amp; Academic Information</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

            <!-- Name -->
            <?= $form->field($model, 'name', $fieldConfig)
                ->textInput([
                    'class' => $inputClass,
                    'placeholder' => 'Enter your full name',
                ]) ?>

            <!-- Course Name -->
            <?= $form->field($model, 'course_name', $fieldConfig)
                ->textInput([
                    'class' => $inputClass,
                    'placeholder' => 'e.g. Computer Science',
                ]) ?>

            <!-- Year of Study -->
            <?= $form->field($model, 'year_of_study', $fieldConfig)
                ->dropDownList(
                    [
                        '1' => 'Year 1',
                        '2' => 'Year 2',
                        '3' => 'Year 3',
                        '4' => 'Year 4',
                    ],
                    ['class' => $inputClass]
                ) ?>

            <!-- Level of Education -->
            <?= $form->field($model, 'level_of_education', $fieldConfig)
                ->dropDownList(
                    [
                        1 => 'Diploma',
                        2 => 'Undergraduate Degree',
                        3 => 'Masters',
                        4 => 'PhD',
                    ],
                    ['class' => $inputClass]
                ) ?>

            <!-- Expected Completion Date -->
            <?= $form->field($model, 'expected_completion_date', $fieldConfig)
                ->input('date', ['class' => $inputClass]) ?>

            <!-- Area of Interest -->
            <?= $form->field($model, 'area_of_interest', $fieldConfig)
                ->textInput([
                    'class' => $inputClass,
                    'placeholder' => 'e.g. Data Science, UI/UX',
                ]) ?>

            <!-- Institution -->
            <?= $form->field($model, 'institution_id', $fieldConfig)
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map(\frontend\models\Institution::find()->all(), 'id', 'name'),
                    ['class' => $inputClass]
                ) ?>

            <!-- hidden field for user_id -->
            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

        </div>


        <!-- ═══════════════════════════════════════════════════════
         Form Actions
     ═══════════════════════════════════════════════════════ -->
        <div class="flex items-center justify-end gap-6 pt-6 border-t border-outline-variant/20">

            <?php Html::a(
                'Cancel',
                ['attachee/create'],   // adjust route as needed
                ['class' => 'px-8 py-3 font-semibold text-on-surface-variant hover:text-primary transition-colors']
            ) ?>

            <?= Html::submitButton(
                'Save Changes',
                [
                    'class' => 'px-10 py-3 bg-gradient-to-br from-primary to-primary-container '
                        . 'text-on-primary-container rounded-xl font-headline font-bold shadow-lg '
                        . 'hover:-translate-y-0.5 transition-all active:translate-y-0',
                ]
            ) ?>

        </div>


        <?php ActiveForm::end(); ?>

    </section>

    <!-- ═══════════════════════════════════════════════════════
     Section 2: Document Uploads
     ═══════════════════════════════════════════════════════ -->

    <section class="bg-surface-container-low rounded-xl p-8 space-y-6">


        <div class="flex items-center gap-4 mb-4">
            <div class="w-10 h-10 rounded-full bg-primary-container/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary-container">description</span>
            </div>
            <h2 class="font-headline font-bold text-2xl text-on-surface">Document Uploads</h2>
        </div>

        <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_4px_20px_rgba(25,28,33,0.03)]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-surface-container-high text-on-surface-variant font-label text-xs uppercase tracking-widest">
                        <th class="px-6 py-4 font-semibold">Document Name</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">



                    <?php if (is_array($templates) && count($templates) > 0): ?>
                        <?php foreach ($templates as $key => $t): ?>
                            <?php
                            $uploaded = \frontend\models\AttacheeDocumentsTemplates::getAttacheeUploadedDocument($t['id'], $model->attachee_reference);
                            $status = $uploaded ? '<span class="material-symbols-outlined text-[14px] mr-1">check</span> Uploaded' : ' <span class="material-symbols-outlined text-[14px] mr-1">warning</span> Missing';
                            $statusClass = $uploaded ? 'text-green-600 bg-green-50' : 'bg-error-container text-on-error-container';
                            $documentPath = \frontend\models\AttacheeDocumentsTemplates::getAttacheeUploadedDocumentPath($t['id'], $model->attachee_reference);
                            ?>

                            <!-- Row 3: Copy of National ID — Missing (prominent Upload Now CTA) -->
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-5 font-medium text-on-surface"><?= $t['document_description'] ?></td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                        <?= $status ?>
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center gap-4 justify-end">
                                        <?= Html::a(
                                            '<span class="material-symbols-outlined text-[18px]">visibility</span> View',
                                            ['attachee/read', 'link' => $documentPath, 'profileId' => $model->id],   // adjust route as needed
                                            [
                                                'class' => 'text-primary-container outline outline-1 outline-primary-container/30 rounded-lg px-3 py-1 font-semibold text-sm hover:underline flex items-center gap-1 justify-end ml-auto',
                                                'encode' => false,
                                            ]
                                        ) ?>
                                        <!-- inline upload form -->
                                        <?php $form = ActiveForm::begin(['id' => 'national-id-form-' . $t['id'], 'options' => ['name' => $file->formName()]]); ?>
                                        <?= $form->field($file, 'attachee_id')->hiddenInput(['value' => $model->attachee_reference])->label(false) ?>
                                        <?= $form->field($file, 'document_type')->hiddenInput(['value' => $t['id']])->label(false) ?>
                                        <?= $form->field($file, 'attachment', [
                                            'template' => '{input}{error}',
                                            'errorOptions' => ['class' => 'text-xs text-error mt-1 text-right'],
                                        ])->fileInput([
                                                    'id' => 'national-id-input-' . $t['id'],
                                                    'class' => 'hidden',
                                                ])->label(false) ?>
                                        <label for="national-id-input-<?= $t['id'] ?>"
                                            class="inline-block px-4 py-2 bg-primary-container text-on-primary-container rounded-lg font-bold text-xs shadow-sm hover:shadow-md transition-all cursor-pointer">
                                            Upload Now
                                        </label>
                                        <?php ActiveForm::end(); ?>

                                        <!-- end inline upload form -->
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <p class="text-xs text-on-surface-variant italic px-2">Allowed formats: PDF, PNG, JPG (Max 5MB each)</p>
    </section>



</div>

<?php
$this->registerJsFile('@web/js/custom.js', ['depends' => [\yii\web\YiiAsset::class]]);


$script = <<<JS
// Add any custom JavaScript here
 $('input[type=file]').change(function(e){
        const form = e.target.closest('form');
        let Service = $(form).find("input[id=file-service]").val();
        InlineGlobalUpload(Service,'file','attachment','AttacheeDocuments', form);   
    });
JS;

$this->registerJs($script);
?>