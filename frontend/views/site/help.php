<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array|null $manual ['url', 'name', 'size', 'updated', 'type'] or null when not deposited */
/** @var array|null $video  ['url', 'name', 'size', 'updated', 'type'] or null when not deposited */

$this->title = 'Help & Support';
$this->params['breadcrumbs'][] = $this->title;

$fmt = Yii::$app->formatter;
?>
<div class="site-help max-w-5xl mx-auto space-y-8">

    <header>
        <h1 class="font-headline text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight">
            <?= Html::encode($this->title) ?>
        </h1>
        <p class="mt-2 text-on-surface-variant">
            Read the user manual or watch the walkthrough video to learn how to create your profile, upload your
            documents and apply for an attachment slot.
        </p>
    </header>

    <!-- User manual -->
    <section class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-sm ring-1 ring-outline-variant/10">
        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
            <div class="w-14 h-14 rounded-xl bg-primary/5 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-3xl">menu_book</span>
            </div>
            <div class="flex-1">
                <h2 class="font-headline text-xl font-bold text-on-surface">User Manual</h2>
                <?php if ($manual): ?>
                    <p class="text-sm text-on-surface-variant mt-1">
                        PDF &middot; <?= $fmt->asShortSize($manual['size']) ?>
                        &middot; updated <?= $fmt->asDate($manual['updated'], 'medium') ?>
                    </p>
                <?php else: ?>
                    <p class="text-sm text-on-surface-variant mt-1">The user manual is not available yet.</p>
                <?php endif; ?>
            </div>
            <?php if ($manual): ?>
                <div class="flex gap-3">
                    <?= Html::a(
                        '<span class="material-symbols-outlined text-[18px]">open_in_new</span> Open',
                        $manual['url'],
                        [
                            'class' => 'inline-flex items-center gap-2 px-4 py-2 rounded-lg font-bold text-sm text-on-primary hero-gradient shadow-sm hover:brightness-110',
                            'target' => '_blank',
                            'rel' => 'noopener',
                            'encode' => false,
                        ]
                    ) ?>
                    <?= Html::a(
                        '<span class="material-symbols-outlined text-[18px]">download</span> Download',
                        $manual['url'],
                        [
                            'class' => 'inline-flex items-center gap-2 px-4 py-2 rounded-lg font-bold text-sm bg-surface-container-high text-on-surface hover:bg-surface-container-highest',
                            'download' => 'User-Manual.pdf',
                            'encode' => false,
                        ]
                    ) ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Instructional video -->
    <section class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-sm ring-1 ring-outline-variant/10">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-xl bg-primary/5 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-3xl">smart_display</span>
            </div>
            <div>
                <h2 class="font-headline text-xl font-bold text-on-surface">Instructional Video</h2>
                <?php if ($video): ?>
                    <p class="text-sm text-on-surface-variant mt-1">
                        <?= $fmt->asShortSize($video['size']) ?>
                        &middot; updated <?= $fmt->asDate($video['updated'], 'medium') ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($video): ?>
            <video class="w-full rounded-lg bg-black aspect-video" controls preload="metadata" playsinline>
                <source src="<?= Html::encode($video['url']) ?>" type="<?= Html::encode($video['type'] ?: 'video/mp4') ?>">
                Your browser cannot play this video.
                <?= Html::a('Download it instead', $video['url'], ['class' => 'text-primary font-semibold hover:underline']) ?>.
            </video>
        <?php else: ?>
            <div class="w-full aspect-video rounded-lg bg-surface-container flex flex-col items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined text-5xl mb-2">videocam_off</span>
                <p class="text-sm">The instructional video is not available yet.</p>
            </div>
        <?php endif; ?>
    </section>

</div>
