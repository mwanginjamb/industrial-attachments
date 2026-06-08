<?php

/** @var yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\helpers\Html;


AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="light">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="bg-background font-body text-on-background">
<?php $this->beginBody() ?>




        <!-- Flash Alerts -->
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $messages): ?>
            <?php
            // Map Yii flash types → Tailwind color tokens
            $alertConfig = match($type) { 
                'success' => ['bg' => 'bg-secondary-fixed',      'text' => 'text-on-secondary-fixed', 'icon' => 'check_circle',      'dot' => 'bg-primary'],
                'error',
                'danger'  => ['bg' => 'bg-error-container',      'text' => 'text-on-error-container', 'icon' => 'error',             'dot' => 'bg-error'],
                'warning' => ['bg' => 'bg-tertiary-fixed',        'text' => 'text-on-tertiary-fixed',  'icon' => 'warning',           'dot' => 'bg-tertiary'],
                'info'    => ['bg' => 'bg-primary-fixed',         'text' => 'text-on-primary-fixed',   'icon' => 'info',              'dot' => 'bg-primary'],
                default   => ['bg' => 'bg-surface-container-high','text' => 'text-on-surface-variant', 'icon' => 'notifications',     'dot' => 'bg-outline'],
            };
            $messages = (array) $messages;
            foreach ($messages as $message):
            ?>
            <div
                role="alert"
                class="flex items-start gap-4 mb-4 px-5 py-4 rounded-2xl <?= $alertConfig['bg'] ?> <?= $alertConfig['text'] ?> shadow-sm"
                x-data="{ show: true }"
            >
                <span class="material-symbols-outlined mt-0.5 flex-shrink-0"><?= $alertConfig['icon'] ?></span>
                <span class="flex-1 text-sm font-medium font-['Inter']"><?= Html::encode($message) ?></span>
                <!-- Dismiss button (purely CSS-driven; swap for JS if needed) -->
                <button
                    type="button"
                    class="ml-auto p-1 rounded-lg hover:bg-black/10 transition-colors flex-shrink-0"
                    onclick="this.closest('[role=alert]').remove()"
                    aria-label="Dismiss"
                >
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>
            <?php endforeach; ?>
        <?php endforeach; ?>


<main class="min-h-screen flex flex-col md:flex-row">
    <section class="relative w-full md:w-1/2 lg:w-3/5 min-h-[400px] md:min-h-screen hero-gradient flex flex-col justify-between p-8 md:p-16 overflow-hidden">
       <!-- Background Texture -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <img alt="" class="w-full h-full object-cover mix-blend-overlay" data-alt="Abstract architectural lines of a modern university building with sunlight filtering through glass panels, high-end editorial style" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAHr91z-B7uSN3-pLPvhgNPQW70czsvURlJe2zO-OKFcdUlP9NujIhI6f3ZCusOdqwr70zKun0H2mKw0u4_505VT3SnktOfYTALF4OoxtUZszBzpSPMNdFDmOI22bdRtpqJgORUJXA-iLRCW6MCdHcL7Oq4bmLwFtnFk4ROelcErFeFYvH2Mctp9HjpCU6dQSNkJdThB4CmspaocJDrWp_jHimrKu5UvxkI8rmFFwFv3RNlYavUpufZg7RfMU1CxH5IjZCefdINoYU"/>
    </div> 
    <!-- Header/Logo Area -->
    <div class="relative z-10 flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                <span class="material-symbols-outlined text-primary text-3xl">school</span>
            </div>
            <div>
                <h1 class="font-headline font-black text-2xl text-white tracking-tighter"><?= Html::encode(Yii::$app->name) ?></h1>
                <p class="font-label text-xs uppercase tracking-[0.2em] text-white/70"><?= env('CUSTOMER') ?> Portal</p>
            </div>
        </div>

        <div class="relative z-10 max-w-xl">
            <h2 class="font-headline text-4xl md:text-6xl font-extrabold text-white leading-[1.1] mb-6 tracking-tight">
                Your bridge to <br/><span class="text-secondary-fixed">professional excellence.</span>
            </h2>
            <p class="text-lg md:text-xl text-white/80 leading-relaxed font-light mb-8">
                Seamlessly connect with leading industry partners, manage your attachment documentation, and accelerate your career trajectory.
            </p>
        </div>

        <div class="relative z-10 text-white/50 text-xs font-label">
            &copy; <?= date('Y') ?> <?= env('APP_NAME','KEMRI Attachments Portal') ?> All rights reserved  ?>
        </div>
    </section>

    <section class="w-full md:w-1/2 lg:w-2/5 flex items-center justify-center p-6 md:p-12 bg-surface">
        <div class="w-full max-w-md">
            <div class="md:hidden flex items-center gap-3 mb-12">
                <span class="material-symbols-outlined text-primary text-4xl">school</span>
                <h1 class="font-headline font-black text-xl text-on-background tracking-tighter"><?= env('APP_NAME') ?></h1>
            </div>

            <?= Alert::widget() ?>
            <?= $content ?>

            <div class="mt-16 flex justify-center gap-6">
                <button class="flex items-center gap-1 text-xs font-label text-outline hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined text-sm">language</span> English (US)
                </button>
                <button class="flex items-center gap-1 text-xs font-label text-outline hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined text-sm">help</span> Support Center
                </button>
            </div>
        </div>
    </section>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>