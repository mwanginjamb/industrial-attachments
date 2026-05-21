<?php

/** @var yii\web\View $this */
/** @var string $content */
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap5\Alert;
use yii\helpers\Url;

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::$app->request->baseUrl . '/favicon.ico']);

// Enqueue Google Fonts & Material Symbols
$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => true]);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="light">
<head>
    <title><?= Html::encode($this->title) ?> | <?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
    
</head>

<body class="bg-surface text-on-surface h-screen flex flex-col overflow-hidden">
<?php $this->beginBody() ?>

<!-- ═══════════════════════════════════════════
     SIDE NAVIGATION
═══════════════════════════════════════════ -->
<aside class="h-screen w-64 fixed left-0 top-0 overflow-y-auto bg-slate-100 dark:bg-slate-950 flex flex-col gap-2 p-4 border-r border-slate-200/10 z-40">

    <!-- Brand  -->
     <a href="<?= Url::toRoute('site/index') ?>">
    <div class="mb-8 px-2">
        <h2 class="font-['Manrope'] font-bold text-lg text-slate-900 dark:text-slate-50">
            <?= Html::encode(Yii::$app->name) ?>
        </h2>
        <p class="text-xs text-on-surface-variant opacity-70"><?= Html::encode(env('CUSTOMER')) ?></p>
    </div>
    </a>

    <!-- Primary Navigation -->
    <nav class="flex-1 space-y-1">
    <?php
    $sideNavItems = [
        //['label' => 'Overview',         'url' => ['/site/index'],       'icon' => 'dashboard'],
        ['label' => 'Student List',     'url' => ['/lot/index'],    'icon' => 'group'],
        //['label' => 'Company Partners', 'url' => ['/company/index'],    'icon' => 'business_center'],
       // ['label' => 'Document Review',  'url' => ['/document/index'],   'icon' => 'description'],
       // ['label' => 'System Logs',      'url' => ['/log/index'],        'icon' => 'analytics'],

        // ── Nested group: add a 'children' key, no 'url' ──
        [
            'label'    => 'RBAC Mgt',
            'icon'     => 'admin_panel_settings',  // icon for the group header (optional)
            'group'    => true,                    // flag to render as accordion
            'children' => [
                ['label' => 'User Role Assignment', 'url' => ['/rbac/user-roles'],   'icon' => 'manage_accounts'],
                ['label' => 'Roles',  'url' => ['/rbac/index'],        'icon' => 'security_update_good'],
                ['label' => 'Permissions',         'url' => ['/rbac/permissions'],        'icon' => 'security'],
                ['label' => 'System Users',           'url' => ['/site/users'],        'icon' => 'group'],
                ['label' => 'Review Status', 'url' => ['/application-status/index'], 'icon' => 'checklist'],
                ['label' => 'Placement Areas',           'url' => ['/placement-area/index'],        'icon' => 'map'],
                ['label' => 'Intake Lots',           'url' => ['/lot/index'],        'icon' => 'view_list'],
            ],
        ],
    ];

    $currentRoute = '/' . Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
    $activeClasses   = 'bg-white dark:bg-slate-900 text-blue-700 dark:text-blue-400 rounded-lg shadow-sm font-bold';
    $inactiveClasses = 'text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:pl-2 transition-all duration-300 font-medium';

    foreach ($sideNavItems as $idx => $item):

        // ── GROUP / ACCORDION ──────────────────────────────────────────────────
        if (!empty($item['group'])):
            /*
             * Check if ANY child is active — if so, open the accordion by default
             * so the active child is visible on page load.
             */
            $groupHasActive = false;
            foreach ($item['children'] as $child) {
                if (Yii::$app->urlManager->createUrl($child['url']) === Yii::$app->urlManager->createUrl([$currentRoute])) {
                    $groupHasActive = true;
                    break;
                }
            }
            $groupId = 'nav-group-' . $idx;
    ?>
        <div class="space-y-1">
            <!-- Group toggle button -->
            <button
                data-accordion-toggle="<?= $groupId ?>"
                aria-expanded="<?= $groupHasActive ? 'true' : 'false' ?>"
                aria-controls="<?= $groupId ?>"
                class="w-full flex items-center justify-between px-4 pt-4 pb-2 group"
            >
                <span class="material-symbols-outlined text-xl">
                    <?= $item['icon'] ?>
                </span>
                
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider group-hover:text-slate-600 transition-colors">
                    <?= Html::encode($item['label']) ?>
                </p>
                <span class="material-symbols-outlined text-slate-400 text-sm accordion-chevron <?= $groupHasActive ? 'rotate-180' : '' ?>"
                      style="transition: transform 260ms cubic-bezier(.4,0,.2,1);">
                    expand_more
                </span>
            </button>

            <!-- Collapsible submenu -->
            <div
                id="<?= $groupId ?>"
                class="nav-accordion-panel space-y-1 <?= $groupHasActive ? 'open' : '' ?>"
            >
                <div class="inner">
                    <?php foreach ($item['children'] as $child):
                        $isActive = Yii::$app->urlManager->createUrl($child['url']) === Yii::$app->urlManager->createUrl([$currentRoute]);
                    ?>
                        <?= Html::a(
                            '<span class="material-symbols-outlined text-xl">' . $child['icon'] . '</span>'
                            . '<span>' . Html::encode($child['label']) . '</span>',
                            $child['url'],
                            [
                                'class'  => 'flex items-center gap-3 px-4 py-2.5 text-sm ml-2 rounded-lg '
                                          . ($isActive ? $activeClasses : $inactiveClasses),
                                'encode' => false,
                            ]
                        ) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    <?php
        // ── FLAT LINK ──────────────────────────────────────────────────────────
        else:
            $isActive = Yii::$app->urlManager->createUrl($item['url']) === Yii::$app->urlManager->createUrl([$currentRoute]);
    ?>
        <?= Html::a(
            '<span class="material-symbols-outlined">' . $item['icon'] . '</span>'
            . '<span>' . Html::encode($item['label']) . '</span>',
            $item['url'],
            [
                'class'  => 'flex items-center gap-3 px-3 py-2 text-sm ' . ($isActive ? $activeClasses : $inactiveClasses),
                'encode' => false,
            ]
        ) ?>
    <?php endif; ?>
    <?php endforeach; ?>
</nav>

    <!-- Bottom Actions -->
    <div class="mt-auto pt-4 space-y-1">
        <button class="w-full bg-primary-container text-white py-2.5 rounded-xl font-semibold text-sm mb-4 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
            Generate Report
        </button>
        <?= Html::a(
            '<span class="material-symbols-outlined">help</span><span>Help Center</span>',
            ['/site/help'],
            ['class' => 'flex items-center gap-3 px-3 py-2 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:pl-2 transition-all duration-300 font-[\'Inter\'] text-sm font-medium', 'encode' => false]
        ) ?>
        <?= Html::a(
            '<span class="material-symbols-outlined">logout</span><span>Sign Out</span>',
            ['/site/logout'],
            ['class' => 'flex items-center gap-3 px-3 py-2 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:pl-2 transition-all duration-300 font-[\'Inter\'] text-sm font-medium', 'data-method' => 'post', 'encode' => false]
        ) ?>
    </div>

</aside>
<!-- /aside -->


<!-- ═══════════════════════════════════════════
     MAIN CONTENT WRAPPER
═══════════════════════════════════════════ -->
<div class="flex-1 ml-64 flex flex-col overflow-hidden">

    <!-- ─────────────────────────────────────
         TOP NAVIGATION BAR
    ───────────────────────────────────── -->
    <header class="bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-30 shadow-sm shadow-blue-900/5">
        <div class="flex justify-between items-center w-full px-8 py-4 max-w-screen-2xl mx-auto">

            <!-- Left: Brand + Top Nav -->
            <div class="flex items-center gap-8">
                <!-- <span class="text-2xl font-black text-blue-900 dark:text-blue-100 tracking-tighter font-['Manrope']">
                    <?= Html::encode(Yii::$app->name) ?>
                </span> -->
                <nav class="hidden md:flex items-center gap-6">
                    <?php
                    $topNavItems = [
                        ['label' => 'Dashboard',     'url' => ['/site/index']],
                        //['label' => 'My Applications',  'url' => ['/site/my-applications']],

                       
                    ];
                    foreach ($topNavItems as $nav):
                        $isTopActive = str_starts_with($currentRoute, '/' . explode('/', $nav['url'][0])[1]);
                        $topActiveClass   = 'text-blue-700 dark:text-blue-400 border-b-2 border-blue-700 dark:border-blue-400 pb-1';
                        $topInactiveClass = 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300';
                    ?>
                    <?= Html::a(
                        Html::encode($nav['label']),
                        $nav['url'],
                        ['class' => 'font-[\'Manrope\'] tracking-tight font-semibold ' . ($isTopActive ? $topActiveClass : $topInactiveClass)]
                    ) ?>
                    <?php endforeach; ?>
                </nav>
            </div>

            <!-- Right: Search + Icons + Avatar -->
            <div class="flex items-center gap-4">
                <div class="relative hidden lg:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                    <input
                        class="pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-full text-sm focus:ring-2 focus:ring-primary/20 w-64"
                        type="text"
                        placeholder="Search..."
                    />
                </div>
                <button class="p-2 text-slate-600 hover:bg-slate-200/50 rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <?= Html::a(
                    '<span class="material-symbols-outlined">settings</span>',
                    ['/site/settings'],
                    ['class' => 'p-2 text-slate-600 hover:bg-slate-200/50 rounded-full transition-colors', 'encode' => false]
                ) ?>
                <!-- User avatar -->
                <div class="h-8 w-8 rounded-full bg-primary-container overflow-hidden">
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->profile_photo ?? null): ?>
                        <img
                            src="<?= Html::encode(Yii::$app->user->identity->profile_photo) ?>"
                            alt="<?= Html::encode(Yii::$app->user->identity->username ?? 'User') ?>"
                            class="h-full w-full object-cover"
                        />
                    <?php else: ?>
                        <span class="flex items-center justify-center h-full w-full text-white text-xs font-bold font-['Manrope']">
                            <?= Yii::$app->user->isGuest ? 'G' : strtoupper(substr(Yii::$app->user->identity->username ?? 'U', 0, 1)) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </header>
    <!-- /header -->


    <!-- ─────────────────────────────────────
         CONTENT CANVAS
    ───────────────────────────────────── -->
    <main class="p-8 max-w-screen-2xl mx-auto w-full flex-1 overflow-y-auto">

        <!-- Breadcrumbs Widget -->
        <?php if (!empty($this->params['breadcrumbs'])): ?>
        <nav class="flex items-center gap-2 text-xs text-on-surface-variant font-medium mb-6">
            <?= Breadcrumbs::widget([
                'links'               => $this->params['breadcrumbs'] ?? [],
                'homeLink'            => ['label' => 'Admin', 'url' => Yii::$app->homeUrl],
                'tag'                 => false,   // render as flat content, no <ul>
                'itemTemplate'        => "<span>{link} </span>". '<span class="material-symbols-outlined">chevron_right</span>' . "\n",
                'activeItemTemplate'  => '<span class="text-on-surface">{link}</span>' . "\n",
                'encodeLabels'        => true,
                'options'             => ['class' => 'contents'],  // no wrapper element
            ]) ?>
        </nav>
        <?php endif; ?>

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

         <?php Alert::widget() ?>
        <!-- ★ Page content injected here ★ -->
        <?= $content ?>

    </main>
    <!-- /main -->


    <!-- ─────────────────────────────────────
         FOOTER
    ───────────────────────────────────── -->
    <footer class="w-full py-12 mt-12 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
        <div class="flex flex-col md:flex-row justify-between items-center px-8 max-w-screen-2xl mx-auto gap-4">
            <span class="font-['Manrope'] font-bold text-slate-400">
                <?= Html::encode(Yii::$app->name) ?> Portal
            </span>
            <div class="flex gap-6">
                <?= Html::a('Privacy Policy',    ['/site/privacy'],    ['class' => 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80 font-[\'Inter\'] text-xs']) ?>
                <?= Html::a('Terms of Service',  ['/site/terms'],      ['class' => 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80 font-[\'Inter\'] text-xs']) ?>
                <?= Html::a('Accessibility',     ['/site/a11y'],       ['class' => 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80 font-[\'Inter\'] text-xs']) ?>
                <?= Html::a('Contact Support',   ['/site/contact'],    ['class' => 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-opacity hover:opacity-80 font-[\'Inter\'] text-xs']) ?>
            </div>
            <p class="font-['Inter'] text-xs text-slate-500">
                © <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?> Portal. All rights reserved.
            </p>
        </div>
    </footer>
    <!-- /footer -->

</div>
<!-- /main content wrapper -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>