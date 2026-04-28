<?php
$this->title = 'Industrial Attachment Vacancies';
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Html;
?>

<!-- Hero Section -->
<section class="relative px-8 py-10 md:py-16 overflow-hidden">
    <div class="max-w-screen-2xl mx-auto flex flex-col md:flex-row items-center gap-12 relative z-10">
        <div class="flex-1 text-center md:text-left">
            <h1
                class="font-headline font-extrabold text-5xl md:text-7xl text-on-surface leading-tight tracking-tight mb-6">
                Find Your Next <br />
                <span class="text-primary italic">Industrial Attachment</span>
            </h1>
            <p class="text-lg md:text-xl text-on-surface-variant max-w-2xl font-body leading-relaxed mb-10">
                Bridging the gap between academic theory and professional practice. Access curated opportunities with
                global industry leaders and leading research institutions.
            </p>
            <!-- <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                <button
                    class="px-8 py-4 hero-gradient text-on-primary rounded-xl font-headline font-bold text-lg shadow-lg hover:shadow-xl transition-all active:scale-95">Explore
                    Opportunities</button>
                <button
                    class="px-8 py-4 bg-surface-container-highest text-on-surface font-headline font-bold text-lg rounded-xl hover:bg-surface-container-low transition-all">View
                    Institutions</button>
            </div> -->
        </div>
        <div class="flex-1 w-full max-w-xl">
            <div class="relative group">
                <div
                    class="absolute -inset-4 bg-primary-fixed/30 rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity">
                </div>
                <img alt="University students collaborating"
                    class="relative rounded-3xl object-cover aspect-[4/3] shadow-2xl ghost-border"
                    data-alt="Modern bright university campus scene with diverse students collaborating on laptops in a clean minimalist architectural space"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCtI4kB__3lePP8Uyz8CIf9qEXAFk2URNlkFLi2Q49KKFUFz7E54iDGy4X3FTh2WsL8a_rCgEbeClewmxXUndK1FfuAkjO5O6QFHvW3bDQEFh5-Py6daEnBPBFuTmJeqaoZkn472waN2hxQ8WBvePf2RyVIecuz-tXIgF2kv4_3U912b2VU3ACwXZuZvmB5gollGKIEbxbu7EyS0yQtm9AwY-QQHGXQVmCcSfEFFZcEaqylSkCJdiJsY9MiSdmgdLGPuunUxkaUoXY" />
            </div>
        </div>
    </div>
</section>
<!-- Active Lots Section -->
<section class="px-8 py-10 bg-surface-container-low">
    <div class="max-w-screen-2xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="font-label text-sm font-semibold text-primary uppercase tracking-widest">Enrollment
                        Open</span>
                </div>
                <h2 class="font-headline font-bold text-4xl text-on-surface">Industrial Attachment Opportunities - <?= date('Y') ?></h2>
            </div>
            <div class="flex gap-3">
                <button class="p-3 bg-[#1f74bf] text-white rounded-full transition-all ghost-border" id="grid-view-btn">
                    <span class="material-symbols-outlined">grid_view</span>
                </button>
                <button
                    class="p-3 bg-surface-container-lowest text-on-surface-variant rounded-full hover:text-primary transition-colors ghost-border"
                    id="list-view-btn">
                    <span class="material-symbols-outlined">view_list</span>
                </button>
            </div>
        </div>
        <!-- Bento-style Grid -->
        <div id="lots-container-wrapper">
            <!-- Grid View -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="grid-view-container">

                <?php if (is_array($lots) && count($lots)):

                    foreach ($lots as $lot): 
                    $active = $lot->isActive ? 'Active' : 'Inactive';
                    $activeClass = $lot->isActive ? 'bg-secondary-fixed' : 'bg-surface-container-highest';
                   
                   ?>

                        <!-- Card 1 -->
                        <div
                            class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm hover:shadow-md transition-all flex flex-col group ghost-border">
                            <div class="flex justify-between items-start mb-6">
                                <div
                                    class="w-14 h-14 bg-primary-fixed rounded-2xl flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-3xl" data-weight="fill">engineering</span>
                                </div>
                                <span
                                    class="px-3 py-1 <?= $activeClass ?> text-on-secondary-fixed text-xs font-bold rounded-full uppercase tracking-tighter"><?= $active?></span>
                            </div>
                            <h3
                                class="font-headline font-bold text-2xl mb-2 text-on-surface group-hover:text-primary transition-colors">
                                <?= $lot['description'] ?>
                            </h3>
                            <p class="text-on-surface-variant font-body mb-8"></p>
                            <div class="mt-auto space-y-4">
                                <div
                                    class="flex items-center justify-between text-sm py-3 border-t border-surface-container-high">
                                    <span class="text-on-surface-variant text-primary">Start Date</span>
                                    <span
                                        class="font-semibold text-on-surface"><?= Yii::$app->formatter->asDatetime($lot->opening_date) ?></span>
                                    <span class="text-on-surface-variant text-danger">Closing Date</span>
                                    <span
                                        class="font-semibold text-on-surface"><?= Yii::$app->formatter->asDatetime($lot->closing_date) ?></span>
                                </div>
                                <!-- <button
                                    class="w-full py-4 hero-gradient text-on-primary font-headline font-bold rounded-xl transition-all hover:brightness-110 active:scale-[0.98]">Apply
                                    Now</button> -->

                                    <!-- Disable apply button if lot is not active and apply suitable css class -->
                                    <?php 
                                        $applyButtonClass = 'block text-center w-full py-4 hero-gradient text-on-primary font-headline font-bold rounded-xl transition-all hover:brightness-110 active:scale-[0.98]';

                                        $url = ['/application/apply', 'lot' => $lot->id];

                                        if (!$lot->isActive) {
                                            $applyButtonClass = 'block text-center w-full py-4 bg-surface-container-high text-on-surface-variant font-headline font-bold rounded-xl cursor-not-allowed';
                                            $url = 'javascript:void(0);'; // disable navigation
                                        }
                                        ?>

                                        <?= Html::a('Apply Now', $url, [
                                            'class' => $applyButtonClass,
                                        ]) ?>
                            </div>
                        </div>
                        <?php
                    endforeach;

                else:
                    '<p>No active lots found</p>';
                endif;


                ?>
                <!-- Card 2 -->

                <!-- Card 3 -->

                <!-- Card 4 Featured -->

                <!-- Stat Card -->
                <!-- <div
                    class="bg-primary text-on-primary rounded-3xl p-8 flex flex-col justify-center items-center text-center">
                    <div class="text-5xl font-headline font-extrabold mb-2">450+</div>
                    <div class="font-headline font-bold text-lg opacity-90 uppercase tracking-widest mb-6">Placements
                    </div>
                    <p class="text-on-primary/80 font-body text-sm leading-relaxed mb-6">Connecting you with the world's
                        most prestigious industrial anchors.</p>
                    <button
                        class="w-full py-3 bg-white/20 backdrop-blur-md text-white font-headline font-bold rounded-xl border border-white/30 hover:bg-white/30 transition-all">View
                        All Labs</button>
                </div> -->
            </div>
            <!-- List View (Hidden by default) -->
            <div class="hidden overflow-hidden" id="list-view-container">
                <div class="bg-surface-container-lowest rounded-3xl shadow-sm ghost-border overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-surface-container-high bg-surface-container-low/50">
                                <th class="p-6 font-headline font-bold text-on-surface">Lot Name</th>
                                <th class="p-6 font-headline font-bold text-on-surface">Start Date</th>
                                <th class="p-6 font-headline font-bold text-on-surface">Closing Date</th>
                                <th class="p-6 font-headline font-bold text-on-surface text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-high">

                            <?php if (is_array($lots) && count($lots) > 0): ?>

                                <?php foreach ($lots as $lot): ?>


                                    <tr class="hover:bg-surface-container-low/30 transition-colors">
                                        <td class="p-6">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 bg-primary-fixed rounded-lg flex items-center justify-center text-primary">
                                                    <span class="material-symbols-outlined text-xl">engineering</span>
                                                </div>
                                                <span class="font-semibold text-on-surface"><?= $lot->description ?></span>
                                            </div>
                                        </td>
                                        <td class="p-6"><span
                                                class="px-3 py-1 bg-secondary-fixed text-on-secondary-fixed text-xs font-bold rounded-full"><?= Yii::$app->formatter->asDatetime($lot->opening_date) ?></span>
                                        </td>
                                        <td class="p-6 text-on-surface-variant">
                                            <span
                                                class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full"><?= Yii::$app->formatter->asDatetime($lot->closing_date) ?>
                                            </span>
                                        </td>
                                        <td class="p-6 text-right">


                                            <?= Html::a('Apply Now', ['/application/apply', 'lot' => $lot->id], [
                                                'class' => 'block text-center text-sm px-4 py-2 hero-gradient text-on-primary font-bold rounded-lg transition-all hover:brightness-110 active:scale-[0.98]'
                                            ]) ?>

                                        </td>
                                    </tr>

                                    <?php
                                endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-on-surface-variant">No active lots found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// load the toggle js
$this->registerJsFile('@web/js/toggle.js', ['depends' => [\yii\web\YiiAsset::class]]);