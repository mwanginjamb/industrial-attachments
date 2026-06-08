<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Attachee $model */

$this->title = 'File Reader';
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attachees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Attache Profile', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Reader');
?>
<div class="attachee-update">

    <!-- Secondary Toolbar -->
<div class="px-8 py-4 bg-surface flex flex-wrap items-center justify-between gap-4">
<div class="flex items-center gap-4">
<h1 class="text-xl font-headline font-bold text-on-surface tracking-tight">Application_Letter_Alex.pdf</h1>
<div class="px-3 py-1 bg-secondary-fixed text-on-secondary-fixed rounded-full text-xs font-semibold flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    Verified
                </div>
</div>
<div class="flex items-center gap-2">
<button class="flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-on-surface rounded-xl transition-all duration-200 text-sm font-medium">
<span class="material-symbols-outlined text-[18px]">download</span>
                    Download
                </button>
<button class="flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-on-surface rounded-xl transition-all duration-200 text-sm font-medium">
<span class="material-symbols-outlined text-[18px]">print</span>
                    Print
                </button>
<div class="w-[1px] h-6 bg-outline-variant/30 mx-2"></div>
<?= Html::a('<span class="material-symbols-outlined text-[18px]">close</span> Close', ['close'], ['class' => 'flex items-center gap-2 px-4 py-2 bg-error-container hover:opacity-90 text-on-error-container rounded-xl transition-all duration-200 text-sm font-medium','encode' => false]) ?>
</div>
</div>
<!-- Hero Viewer Area -->
<section class="flex-1 px-8 pb-8 flex flex-col gap-6 overflow-hidden">
<!-- Asymmetric Bento-style Details for Academic Context -->

<!-- Iframe Container with Placeholder -->
<div class="flex-1 bg-surface-container rounded-full relative group overflow-hidden shadow-[0_12px_40px_rgba(25,28,33,0.04)] border border-outline-variant/10">
<!-- Loading State / Placeholder -->
<div class="absolute inset-0 flex flex-col items-center justify-center z-10 bg-surface-container-lowest/50">
<div class="w-16 h-16 rounded-full bg-primary-container/10 flex items-center justify-center mb-4">
<span class="material-symbols-outlined text-primary text-4xl animate-pulse">description</span>
</div>

<div class="w-64 h-1.5 bg-surface-container-high rounded-full mt-6 overflow-hidden">
<div class="loading-shimmer h-full w-full"></div>
</div>
</div>
<!-- Actual Iframe -->
<?php if ($content)
print '<iframe class="" src="data:application/pdf;base64,' . $content . '" height="950px" width="100%"></iframe>';
else
print '<iframe class="w-full h-full border-none relative z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-700" src="about:blank" title="Document View"></iframe>';
?>
<!-- Contextual Overlay for Premium feel -->
<div class="absolute bottom-6 right-6 z-30 flex gap-2">
<button class="bg-[#f8f9ff]/90 backdrop-blur-md px-4 py-2 rounded-full shadow-lg border border-white/20 text-xs font-bold text-on-surface flex items-center gap-2 hover:bg-white transition-all">
<span class="material-symbols-outlined text-[16px]">qr_code_2</span>
                        Scan Verification
                    </button>
</div>
</div>
</section>


   
</div>
