<?php

/** @var yii\web\View $this */
/** @var string $content */
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html class="light" lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        <?= Html::encode($this->title) ?> | Academic Curator
    </title>

    <?php $this->head() ?>


</head>

<body class="bg-background font-body text-on-background selection:bg-secondary-fixed">
    <?php $this->beginBody() ?>

    <!-- ===================== TOP NAV BAR ===================== -->
    <nav class="bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm shadow-blue-900/5 top-0 sticky z-50">
        <div class="flex justify-between items-center w-full px-8 py-4 max-w-screen-2xl mx-auto">

            <!-- Brand + Nav Links -->
            <div class="flex items-center gap-8">
                <?= Html::a(
                    'Academic Curator',
                    Url::to(['/site/index']),
                    ['class' => "text-2xl font-black text-blue-900 dark:text-blue-100 tracking-tighter font-['Manrope']"]
                ) ?>

                <div class="hidden md:flex items-center gap-6">
                    <?= Html::a('Dashboard', Url::to(['/site/index']), ['class' => $this->context->id === 'site' && $this->context->action->id === 'index' ? "text-blue-700 dark:text-blue-400 border-b-2 border-blue-700 dark:border-blue-400 pb-1 font-['Manrope'] tracking-tight font-semibold" : "text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 transition-colors duration-200 font-['Manrope'] tracking-tight font-semibold"]) ?>
                    <?= Html::a('Applications', Url::to(['/application/index']), ['class' => $this->context->id === 'application' ? "text-blue-700 dark:text-blue-400 border-b-2 border-blue-700 dark:border-blue-400 pb-1 font-['Manrope'] tracking-tight font-semibold" : "text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 transition-colors duration-200 font-['Manrope'] tracking-tight font-semibold"]) ?>
                    <?= Html::a('Placements', Url::to(['/placement/index']), ['class' => $this->context->id === 'placement' ? "text-blue-700 dark:text-blue-400 border-b-2 border-blue-700 dark:border-blue-400 pb-1 font-['Manrope'] tracking-tight font-semibold" : "text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 transition-colors duration-200 font-['Manrope'] tracking-tight font-semibold"]) ?>
                    <?= Html::a('Resources', Url::to(['/resource/index']), ['class' => $this->context->id === 'resource' ? "text-blue-700 dark:text-blue-400 border-b-2 border-blue-700 dark:border-blue-400 pb-1 font-['Manrope'] tracking-tight font-semibold" : "text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 transition-colors duration-200 font-['Manrope'] tracking-tight font-semibold"]) ?>
                </div>
            </div>

            <!-- Right: Actions + User -->
            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <button
                    class="p-2 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-full transition-colors duration-200">
                    <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                </button>
                <!-- Settings -->
                <button
                    class="p-2 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-full transition-colors duration-200">
                    <span class="material-symbols-outlined text-on-surface-variant">settings</span>
                </button>

                <!-- User Profile -->
                <div class="flex items-center gap-3 pl-4 ml-4 border-l border-outline-variant/30">
                    <span class="text-sm font-semibold font-headline hidden lg:block">
                        <?= Html::encode(Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username) ?>
                    </span>
                    <?php if (!Yii::$app->user->isGuest && !empty(Yii::$app->user->identity->avatar)): ?>
                        <?= Html::img(
                            Yii::$app->user->identity->avatar,
                            ['class' => 'w-10 h-10 rounded-full border-2 border-primary/10', 'alt' => 'User avatar']
                        ) ?>
                    <?php else: ?>
                        <!-- Fallback initials avatar -->
                        <div
                            class="w-10 h-10 rounded-full border-2 border-primary/10 primary-gradient flex items-center justify-center text-on-primary font-bold text-sm">
                            <?= strtoupper(substr(Yii::$app->user->isGuest ? 'G' : Yii::$app->user->identity->username, 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </nav>
    <!-- ===================== END TOP NAV BAR ===================== -->


    <!-- ===================== PAGE CONTENT ===================== -->
    <main class="max-w-screen-2xl mx-auto px-8 py-12">
        <?= $content ?>
    </main>
    <!-- ===================== END PAGE CONTENT ===================== -->


    <!-- ===================== FOOTER ===================== -->
    <footer class="bg-slate-50 dark:bg-slate-950 w-full py-12 mt-auto border-t border-slate-200 dark:border-slate-800">
        <div class="flex flex-col md:flex-row justify-between items-center px-8 max-w-screen-2xl mx-auto gap-4">
            <span class="font-['Manrope'] font-bold text-slate-400">Academic Curator</span>
            <span class="font-['Inter'] text-xs text-slate-500">
                ©
                <?= date('Y') ?> Academic Curator Portal. All rights reserved.
            </span>
            <div class="flex gap-6">
                <?= Html::a('Privacy Policy', Url::to(['/site/privacy']), ['class' => "font-['Inter'] text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80"]) ?>
                <?= Html::a('Terms of Service', Url::to(['/site/terms']), ['class' => "font-['Inter'] text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80"]) ?>
                <?= Html::a('Accessibility', Url::to(['/site/accessibility']), ['class' => "font-['Inter'] text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80"]) ?>
                <?= Html::a('Contact Support', Url::to(['/site/contact']), ['class' => "font-['Inter'] text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80"]) ?>
            </div>
        </div>
    </footer>
    <!-- ===================== END FOOTER ===================== -->

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>