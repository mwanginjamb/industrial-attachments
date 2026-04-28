<?php

use frontend\models\File;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Application $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="site-index">
    <!-- Header Section -->
    <header class="mb-12">
        <h1 class="font-headline text-5xl font-extrabold text-on-surface tracking-tighter mb-2">Hallo ,
            <?= ucwords(Yii::$app->user->identity->username) ?>.
        </h1>
        <p class="text-on-surface-variant font-medium text-lg">Your industrial attachment progress is currently being
            curated.</p>
    </header>
    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Application Status & Progress (Col 7) -->
        <div class="lg:col-span-7 space-y-8">
            <!-- Status Card -->
            <section class="bg-surface-container-lowest rounded-xl p-8 shadow-sm ring-1 ring-outline-variant/10">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <span class="text-label-sm font-bold uppercase tracking-widest text-primary mb-2 block">Current
                            Status</span>
                        <h2 class="font-headline text-3xl font-bold text-on-surface">Application Under Review</h2>
                    </div>
                    <div
                        class="bg-secondary-fixed text-on-secondary-fixed px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg"
                            data-icon="hourglass_empty"><?= $StatusIcons[$model->status] ?? 'hourglass_empty' ?></span>
                        <?= $model->status0->description ?>
                    </div>
                </div>
                <!-- Progress Tracker Component -->
                <div class="relative py-4">
                    <div
                        class="absolute top-1/2 left-0 w-full h-1 bg-surface-container-high -translate-y-1/2 rounded-full overflow-hidden">
                        <div class="w-2/3 h-full primary-gradient rounded-full"></div>
                    </div>
                    <div class="relative flex justify-between">
                        <div class="flex flex-col items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full primary-gradient text-on-primary flex items-center justify-center z-10 shadow-lg">
                                <span class="material-symbols-outlined" data-icon="check"
                                    style="font-variation-settings: 'FILL' 0; font-weight: 700;">check</span>
                            </div>
                            <span class="text-xs font-bold font-headline text-on-surface">Submitted</span>
                        </div>
                        <div class="flex flex-col items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full primary-gradient text-on-primary flex items-center justify-center z-10 shadow-lg">
                                <span class="material-symbols-outlined" data-icon="edit_note">edit_note</span>
                            </div>
                            <span class="text-xs font-bold font-headline text-on-surface">Reviewing</span>
                        </div>
                        <div class="flex flex-col items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center z-10">
                                <span class="material-symbols-outlined" data-icon="verified">verified</span>
                            </div>
                            <span class="text-xs font-bold font-headline text-outline">Accepted</span>
                        </div>
                        <div class="flex flex-col items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center z-10">
                                <span class="material-symbols-outlined" data-icon="apartment">apartment</span>
                            </div>
                            <span class="text-xs font-bold font-headline text-outline">Placed</span>
                        </div>
                    </div>
                </div>
                <div class="mt-12 p-6 bg-surface-container-low rounded-xl flex items-center gap-6">
                    <div
                        class="w-16 h-16 rounded-lg bg-white flex items-center justify-center shadow-sm overflow-hidden">
                        <img alt="Company logo" class="w-full h-full object-cover"
                            data-alt="minimalist modern corporate logo of a tech company on white background"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkq9VwcIMJmxOUyx3_VcITAaDQD5X2daeUcvSQ-qI6qTfiNJg7u9fYYnFXqt_KU6W4QQZYC3n86SScnemr6Fl29eztx9MDsowMQrFzjJhApQfQezR1NiWiJVB57d3PxYLRRvxZRCcoFTkYV5dHrUEiEjFD6miXhcvpr9IsDFa1PEu08BQQQ-eMoLMjFe73NosyadjH_U1rX0-kKYkzFLMZSECJXoqL9reDROm8udchpTL_3_SEcRuGO79SiRGDqDQeKeSayy9fNM0" />
                    </div>
                    <div>
                        <h3 class="font-headline font-bold text-on-surface">Nexus Systems Architecture</h3>
                        <p class="text-sm text-on-surface-variant">Cloud Infrastructure Intern • Nairobi, KE</p>
                    </div>
                    <button class="ml-auto text-primary font-bold text-sm hover:underline">View Details</button>
                </div>
            </section>
            <!-- Compliance Documents Section -->
            <section class="bg-surface-container-lowest rounded-xl p-8 shadow-sm ring-1 ring-outline-variant/10">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="font-headline text-2xl font-bold text-on-surface">Compliance Documents</h2>
                        <p class="text-on-surface-variant text-sm mt-1">Required for institutional approval and
                            insurance.</p>
                    </div>
                    <span class="text-label-md font-bold text-tertiary">
                        <?= $total_attachee_documents ?> of
                        <?= $total_templates ?> Complete
                    </span>
                </div>
                <!-- Document Templates -->
                <div class="space-y-4">
                    <?php foreach ($docTemplates as $k => $doc): ?>
                        <?php $uploaded = ($doc?->attacheeDocument && $doc?->attacheeDocument?->path) ? true : false; ?>

                        <div class="group 
                        flex items-center justify-between  <!-- FIX: match boilerplate (remove flex-col) -->
                        p-4 bg-surface rounded-xl
                        <?= $uploaded ? '' : 'ring-2 ring-error/5' ?>
                        hover:bg-surface-container-low transition-colors duration-200">

                            <!-- Icon + Label -->
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center
                                <?= $uploaded ? 'bg-primary/5 text-primary' : 'bg-error/5 text-error' ?>">
                                    <span class="material-symbols-outlined">
                                        <?= Html::encode($icons[$doc['id']]) ?>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-on-surface text-sm md:text-base">
                                        <?= Html::encode($doc['document_description']) ?>
                                    </h4>
                                    <p class="text-[10px] md:text-xs text-on-surface-variant">
                                        <?= Html::encode($doc['notes']) ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Action area -->
                            <div class="flex items-center gap-4 ml-auto">
                                <!-- FIX: remove w-full + justify-between, add ml-auto to push right -->

                                <?php if ($uploaded): ?>
                                    <!-- Status -->
                                    <div
                                        class="flex items-center gap-1.5 text-green-600 bg-green-50 px-3 py-1 rounded-full text-[10px] md:text-xs font-bold">
                                        <span class="material-symbols-outlined text-sm"
                                            style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        Uploaded
                                    </div>

                                    <!-- View -->
                                    <a href="<?= Url::to(['/document/view', 'path' => $doc?->attacheeDocument?->path]) ?>"
                                        class="text-outline hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>

                                    <!-- FIX: Re-upload action -->

                                    <?= $this->render('_inline_form', ['t' => $doc, 'model' => $attachee, 'file' => new File(), 'labelIcon' => '<span class="material-symbols-outlined text-[18px]">cloud_upload</span> Replace']) ?>

                                <?php else: ?>

                                    <!-- Missing -->
                                    <div
                                        class="flex items-center gap-1.5 text-error bg-error-container/20 px-3 py-1 rounded-full text-[10px] md:text-xs font-bold">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        Missing
                                    </div>

                                    <!-- Upload -->
                                    <!-- <a href="<?= Url::to(['/document/upload', 'type' => 'pdf', 'id' => $doc->id]) ?>"
                                        class="primary-gradient text-on-primary px-4 py-1.5 rounded-lg text-[10px] md:text-xs font-bold shadow-sm transition-transform active:scale-95">
                                        Upload
                                    </a> -->

                                    <?= $this->render('_inline_form', ['t' => $doc, 'model' => $attachee, 'file' => new File(), 'labelIcon' => '<span class="material-symbols-outlined text-[18px]">upload</span> Upload']) ?>

                                <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <!-- /Document Templates -->
            </section>
        </div>
        <!-- Right Column: Quick Stats & Deadlines (Col 5) -->
        <div class="lg:col-span-5 space-y-8">
            <!-- Deadline Sidebar Card -->
            <aside class="bg-primary text-on-primary rounded-xl p-8 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <span class="material-symbols-outlined text-9xl" data-icon="event_available">event_available</span>
                </div>
                <div class="relative z-10">
                    <h3 class="font-headline text-2xl font-bold mb-6">Upcoming Milestones</h3>
                    <div class="space-y-6 gap-0">
                        <?php foreach ($lots as $lot): ?>
                            <?php foreach ($lot->milestones as $milestone): ?>
                                <div class="flex gap-4 items-center py-2">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-lg flex flex-col items-center justify-center p-6">
                                        <span
                                            class="text-[8px] md:text-[10px] uppercase font-bold"><?= Html::encode(date('M', strtotime($milestone['date']))) ?></span>
                                        <span
                                            class="text-base md:text-lg font-bold"><?= Html::encode(date('d', strtotime($milestone['date']))) ?></span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-base md:text-lg leading-tight">
                                            <?= Html::encode($milestone['title']) ?>
                                        </p>
                                        <p class="text-on-primary/70 text-xs md:text-sm">
                                            <?= Html::encode($milestone['description']) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </div>
                    <button
                        class="w-full mt-10 bg-white text-primary font-bold py-3 rounded-lg shadow-sm hover:bg-slate-50 transition-colors">
                        View Full Attachment Calendar
                    </button>
                </div>
            </aside>
            <!-- Help & Guidance Card -->
            <section class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/20">
                <h3 class="font-headline text-xl font-bold text-on-surface mb-6">Recent Applications</h3>
                <div class="grid grid-cols-1 gap-4">

                    <?php if (is_array($applications) && count($applications)): ?>
                        <?php foreach ($applications as $application): ?>
                            <a class="flex items-center gap-4 p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow"
                                href="<?= Url::to(['/application/view', 'id' => $application['id']]) ?>">
                                <span class="material-symbols-outlined text-primary" data-icon="menu_book">menu_book</span>
                                <div>
                                    <p class="font-bold text-sm"><?= Html::encode($application['lot']['description']) ?></p>
                                    <p class="text-xs text-on-surface-variant">
                                        <?= Html::encode($application['status0']['description']) ?>
                                    </p>
                                </div>
                            </a>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- No applications available -->
                        <div class="text-center py-10">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4">menu_book</span>
                            <p class="text-sm text-on-surface-variant">No recent applications found.</p>
                        </div>

                    <?php endif; ?>


                </div>
                <div class="mt-8 rounded-xl overflow-hidden relative group">
                    <img alt="Students studying"
                        class="w-full h-32 object-cover grayscale group-hover:grayscale-0 transition-all duration-500"
                        data-alt="group of diverse students working collaboratively in a bright modern library space with books and laptops"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQ8YZ_K2SzUhwws5kpsL_NRAwJ5U1LdB-V-o2DxyD8-veMHAIWMg4Ni7oj7LWNbRKe5Uz6P51vdmezKvZC5rHJwrMKJMrHa5MEscvxw5PnzMfOptg89WaN1SdnqD9hLWninvI5eMWvD9D2jvhMEjjeSB9ACm7rSBN_tVSbFZwz23YHhaBdkltOzz1r0AVQUD-k-n6SFC6Vbqfnvw0B_wul7W9-YF-J2nhbTQsb3gEKnAZG1xj_EGekxjf4qm2gQbABHWSGXG00wVY" />
                    <div class="absolute inset-0 bg-primary/40 flex items-center justify-center">
                        <span class="text-white font-bold text-sm">Join Student Forum</span>
                    </div>
                </div>
            </section>
        </div>
    </div>
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