<?php

/** @var yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html class="light" lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        <?= Html::encode($this->title) ?> | Academic Curator
    </title>
    <?php $this->head() ?>
</head>

<body class="bg-background font-body text-on-background selection:bg-secondary-fixed"
    onclick="if (!event.target.closest('.group.cursor-pointer')) { document.getElementById('profile-dropdown').classList.add('hidden'); }">
    <?php $this->beginBody() ?>

    <!-- ===== TOP NAV BAR ===== -->
    <nav
        class="bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm shadow-blue-900/5 full-width top-0 sticky z-50">
        <div class="flex justify-between items-center w-full px-4 md:px-8 py-4 max-w-screen-2xl mx-auto">

            <!-- Brand + Desktop Nav -->
            <div class="flex items-center gap-4 md:gap-8">
                <!-- Mobile Menu Trigger -->
                <button class="p-2 md:hidden hover:bg-slate-200/50 rounded-lg transition-colors"
                    onclick="document.getElementById('mobile-menu').classList.remove('hidden')">
                    <span class="material-symbols-outlined text-on-surface">menu</span>
                </button>

                <span
                    class="text-xl md:text-2xl font-black text-blue-900 dark:text-blue-100 tracking-tighter font-headline">
                    Academic Curator
                </span>

                <div class="hidden md:flex items-center gap-6">
                    <?php
                    $navItems = [
                        ['label' => 'Dashboard', 'url' => ['/student/dashboard']],
                        ['label' => 'Applications', 'url' => ['/application/index']],
                        ['label' => 'Placements', 'url' => ['/placement/index']],
                        ['label' => 'Resources', 'url' => ['/resource/index']],
                    ];
                    foreach ($navItems as $item):
                        $isActive = Yii::$app->controller->action->uniqueId === ltrim($item['url'][0], '/');
                        $activeClass = $isActive
                            ? 'text-blue-700 dark:text-blue-400 border-b-2 border-blue-700 dark:border-blue-400 pb-1 font-semibold'
                            : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 transition-colors duration-200 font-semibold';
                        ?>
                        <a class="font-headline tracking-tight <?= $activeClass ?>" href="<?= Url::to($item['url']) ?>">
                            <?= Html::encode($item['label']) ?>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2 md:gap-4">
                <button
                    class="p-2 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-full transition-colors duration-200">
                    <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                </button>
                <button
                    class="hidden md:block p-2 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-full transition-colors duration-200">
                    <span class="material-symbols-outlined text-on-surface-variant">settings</span>
                </button>

                <!-- Profile Dropdown -->
                <div class="flex items-center gap-3 md:pl-4 md:ml-4 md:border-l border-outline-variant/30 cursor-pointer relative group"
                    onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')">

                    <span class="text-sm font-semibold font-headline hidden lg:block">
                        <?= Html::encode(Yii::$app->user->identity->name ?? 'Profile') ?>
                    </span>
                    <?php if (!Yii::$app->user->isGuest && !empty(Yii::$app->user->identity->avatar)): ?>
                        <img alt="User profile avatar"
                            class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-primary/10"
                            src="<?= Html::encode(Yii::$app->user->identity->avatarUrl ?? '/images/default-avatar.png') ?>" />
                    <?php else: ?>
                        <!-- Fallback initials avatar -->
                        <div
                            class="w-10 h-10 rounded-full border-2 border-primary/10 primary-gradient flex items-center justify-center text-on-primary font-bold text-sm">
                            <?= strtoupper(substr(Yii::$app->user->isGuest ? 'G' : Yii::$app->user->identity->username, 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                    <!-- Dropdown Menu -->
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <div class="hidden absolute right-0 top-full mt-2 w-56 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-outline-variant/20 overflow-hidden z-[60] py-2"
                            id="profile-dropdown">


                            <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                                href="<?= Url::to(['/student/profile']) ?>">
                                <span class="material-symbols-outlined text-primary">person_outline</span>
                                View Profile
                            </a>
                            <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                                href="<?= Url::to(['/user/settings']) ?>">
                                <span class="material-symbols-outlined text-primary">manage_accounts</span>
                                Account Settings
                            </a>
                            <a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                                href="<?= Url::to(['/site/help']) ?>">
                                <span class="material-symbols-outlined text-primary">help_outline</span>
                                Help &amp; Support
                            </a>
                            <hr class="my-1 border-outline-variant/10" />


                            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                                . Html::submitButton(
                                    '<span class="material-symbols-outlined">logout</span><span>Sign Out</span> (' . ucwords(Yii::$app->user->identity->username) . ')',
                                    ['class' => 'flex items-center gap-3 px-4 py-3 text-sm font-medium text-error hover:bg-error/5 transition-colors']
                                )
                                . Html::endForm();

                            ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== MOBILE SIDEBAR MENU ===== -->
    <div class="hidden fixed inset-0 z-[100]" id="mobile-menu">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" style="transition: opacity 0.3s ease-in-out;"
            onclick="document.getElementById('mobile-menu').classList.add('hidden')">
        </div>
        <div class="absolute inset-y-0 left-0 w-80 bg-white dark:bg-slate-900 shadow-2xl flex flex-col"
            style="transition: transform 0.3s ease-in-out;">

            <!-- Sidebar Header -->
            <div class="p-6 border-b border-outline-variant/10 flex justify-between items-center">
                <span class="text-xl font-black text-blue-900 dark:text-blue-100 tracking-tighter font-headline">
                    Academic Curator
                </span>
                <button class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800"
                    onclick="document.getElementById('mobile-menu').classList.add('hidden')">
                    <span class="material-symbols-outlined text-on-surface">close</span>
                </button>
            </div>

            <!-- Sidebar Nav -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
                <div>
                    <span class="px-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Navigation</span>
                    <nav class="mt-4 space-y-1">
                        <?php
                        $mobileNavItems = [
                            ['label' => 'Dashboard', 'url' => ['/student/dashboard'], 'icon' => 'dashboard'],
                            ['label' => 'Applications', 'url' => ['/application/index'], 'icon' => 'description'],
                            ['label' => 'Placements', 'url' => ['/placement/index'], 'icon' => 'apartment'],
                            ['label' => 'Resources', 'url' => ['/resource/index'], 'icon' => 'folder_open'],
                        ];
                        foreach ($mobileNavItems as $item):
                            $isActive = Yii::$app->controller->action->uniqueId === ltrim($item['url'][0], '/');
                            $activeClass = $isActive
                                ? 'bg-primary/10 text-primary font-bold'
                                : 'text-slate-600 hover:bg-slate-50 font-semibold';
                            ?>
                            <a class="flex items-center gap-3 px-3 py-3 rounded-lg <?= $activeClass ?>"
                                href="<?= Url::to($item['url']) ?>">
                                <span class="material-symbols-outlined">
                                    <?= $item['icon'] ?>
                                </span>
                                <?= Html::encode($item['label']) ?>
                            </a>
                        <?php endforeach ?>
                    </nav>
                </div>

                <div>
                    <span class="px-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Profile &amp;
                        Account</span>
                    <nav class="mt-4 space-y-1">
                        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 hover:bg-slate-50 font-semibold"
                            href="<?= Url::to(['/student/profile']) ?>">
                            <span class="material-symbols-outlined">person_outline</span>
                            View Profile
                        </a>
                        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 hover:bg-slate-50 font-semibold"
                            href="<?= Url::to(['/user/settings']) ?>">
                            <span class="material-symbols-outlined">manage_accounts</span>
                            Account Settings
                        </a>
                        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 hover:bg-slate-50 font-semibold"
                            href="<?= Url::to(['/site/help']) ?>">
                            <span class="material-symbols-outlined">help_outline</span>
                            Help &amp; Support
                        </a>
                        <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-error hover:bg-error/5 font-semibold"
                            href="<?= Url::to(['/site/logout']) ?>" data-method="post">
                            <span class="material-symbols-outlined">logout</span>
                            Sign Out
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Sidebar Footer: User Info -->
            <div class="p-6 bg-slate-50 dark:bg-slate-800/50 flex items-center gap-4">
                <img alt="User profile avatar" class="w-12 h-12 rounded-full border-2 border-primary/20"
                    src="<?= Html::encode(Yii::$app->user->identity->avatarUrl ?? '/images/default-avatar.png') ?>" />
                <div>
                    <p class="font-bold text-on-surface">
                        <?= Html::encode(Yii::$app->user->identity->name ?? '') ?>
                    </p>
                    <p class="text-xs text-on-surface-variant">
                        <?= Html::encode(Yii::$app->user->identity->programme ?? '') ?>,
                        Year
                        <?= Html::encode(Yii::$app->user->identity->yearOfStudy ?? '') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT AREA ===== -->
    <main class="max-w-screen-2xl mx-auto px-4 md:px-8 py-8 md:py-12">
        <?= $content ?>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer
        class="bg-slate-50 dark:bg-slate-950 w-full py-8 md:py-12 mt-auto border-t border-slate-200 dark:border-slate-800">
        <div class="flex flex-col items-center px-4 md:px-8 max-w-screen-2xl mx-auto gap-6 text-center md:text-left">
            <div class="flex flex-col md:flex-row justify-between items-center w-full gap-4">
                <span class="font-headline font-bold text-slate-400">Academic Curator</span>
                <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                    <a class="font-body text-[10px] md:text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity"
                        href="<?= Url::to(['/site/privacy']) ?>">Privacy Policy</a>
                    <a class="font-body text-[10px] md:text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity"
                        href="<?= Url::to(['/site/terms']) ?>">Terms of Service</a>
                    <a class="font-body text-[10px] md:text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity"
                        href="<?= Url::to(['/site/accessibility']) ?>">Accessibility</a>
                    <a class="font-body text-[10px] md:text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity"
                        href="<?= Url::to(['/site/contact']) ?>">Contact Support</a>
                </div>
            </div>
            <span class="font-body text-[10px] md:text-xs text-slate-500">
                &copy;
                <?= date('Y') ?> Academic Curator Portal. All rights reserved.
            </span>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>