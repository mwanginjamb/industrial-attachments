<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\lot $model */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$selected = <<<ICO
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
ICO;
?>
<div class="lot-view">

    <!-- header div -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-4xl font-extrabold tracking-tight text-on-surface"><?= Html::encode($this->title) ?></h1>
           
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-1 mb-10">
                <span class="text-green-600 text-sm font-medium">Application Start Date: <?= Yii::$app->formatter->asDate($model->applicationStartDate) ?></span>
                <span class="text-error text-sm font-medium">Application End Date: <?= Yii::$app->formatter->asDate($model->applicationDeadline) ?></span>
                <span class="text-on-surface-variant text-sm font-medium">Processing Deadline: <?= Yii::$app->formatter->asDate($model->placementDeadline) ?></span>
            </div>
        </div>
        <div class="flex gap-3">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
    <!-- end header div -->

    <!-- Stats Overview (Asymmetric Grid) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="md:col-span-1 bg-surface-container-low p-6 rounded-xl flex flex-col justify-between">
            <span class="text-on-surface-variant text-sm font-medium">Total Applicants</span>
            <div class="mt-4">
                <span class="text-3xl font-black text-on-surface"><?= $model->applicationsCount ?></span>
                <span class="text-green-600 text-xs font-bold ml-2">↑ 12%</span>
            </div>
        </div>
        <div class="md:col-span-1 bg-surface-container-low p-6 rounded-xl flex flex-col justify-between">
            <span class="text-on-surface-variant text-sm font-medium">Pending Review</span>
            <div class="mt-4">
                <span class="text-3xl font-black text-on-surface">28</span>
            </div>
        </div>
        <div
            class="md:col-span-2 bg-primary-container p-6 rounded-xl flex items-center justify-between text-on-primary-container relative overflow-hidden">
            <div class="z-10">
                <span class="text-sm font-medium opacity-80">Processing Status</span>
                <h3 class="text-2xl font-bold mt-1">Batch 84% Complete</h3>
                <div class="w-48 h-2 bg-white/20 rounded-full mt-3 overflow-hidden">
                    <div class="bg-white h-full w-[84%]"></div>
                </div>
            </div>
            <span
                class="material-symbols-outlined text-8xl absolute -right-4 -bottom-4 opacity-10">assignment_turned_in</span>
        </div>
    </div>

    <!-- end stats overview -->

    <!--Applicants Table -->

    <!-- Data Table Container -->
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden border-none">
        <div
            class="px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-surface-container">
            <h2 class="font-['Manrope'] font-bold text-xl">Applicant Registry</h2>
            <div class="flex gap-2">
                <button
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border-none bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">filter_list</span> Filter
                </button>
                <button
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border-none bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">download</span> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
             <table class="w-full text-left font-['Inter']">
                <thead>
                    <tr
                        class="bg-surface-container-low text-on-surface-variant uppercase text-[10px] font-black tracking-widest">
                        <th class="px-8 py-4">Name &amp; ID</th>
                        <th class="px-6 py-4">Year / Level</th>
                        <th class="px-6 py-4">Institution</th>
                        <th class="px-6 py-4 text-success">Preferred Placement</th>
                        <th class="px-6 py-4 text-success">Selected</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    <?php foreach ($applications as $application):

                        $endpoint = \yii\helpers\Url::home(true) . 'apiv1/applications/' . $application->id;
                        ?>
                        <!-- Row 1 -->
                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                        <?= strtoupper(substr($application['attachee']['name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-on-surface"><?= $application['attachee']['name'] ?></p>
                                        <p class="text-xs text-on-surface-variant">ID:
                                            <?= $application['attachee']['attachee_reference'] ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium"><?= $application['attachee']['year_of_study'] ?></p>
                                <p class="text-xs text-on-surface-variant"><?= $application['attachee']['course_name'] ?>
                                </p>
                            </td>
                            <td class="px-6 py-5 text-sm">
                                <span class="text-on-surface-variant font-medium">
                                    <?= $application?->attachee?->institution?->name ?>
                                </span>
                                <p class="text-xs text-on-surface-variant text-wrap max-w-xs">
                                    <strong>Interests: </strong> <?= $application?->attachee?->area_of_interest ?>
                                </p>
                            </td>
                            <td class="px-6 py-5 text-sm" data-key="<?= $application->id ?>" data-name="placement"
                                data-service="<?= $endpoint ?>" ondblclick="addDropDown(this,'placements')" data-reload=1>
                                <span class="text-on-surface-variant font-medium">
                                    <?= !is_null($application['placement']) ? $application->placementArea->name : 'N/A' ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-sm" data-key="<?= $application->id ?>" data-name="closed"
                                data-service="<?= $endpoint ?>" ondblclick="addInput(this,'checkbox')" data-reload=1>
                                <span class="text-on-surface-variant font-medium">
                                    <?= !is_null($application['closed']) ? $selected : '' ?>
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-[11px] font-bold uppercase tracking-tight"><?= !is_null($application['status0']) ? $application['status0']['description'] : 'N/A' ?></span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <!-- <button
                                    class="px-3 py-1.5 text-xs font-bold text-primary hover:bg-primary/10 rounded-lg transition-colors">Review
                                    Documents</button>
                                <button
                                    class="p-1.5 text-on-surface-variant hover:text-on-surface hover:bg-surface-container rounded-lg"><span
                                        class="material-symbols-outlined text-lg">more_vert</span></button> -->
                                    <?= Html::a('Review Documents', ['attachee/view', 'id' => $application['attachee_id']], ['class' => 'px-3 py-1.5 text-xs font-bold text-primary hover:bg-primary/10 rounded-lg transition-colors']) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>



                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 flex justify-between items-center bg-surface-container-low/20">
            <p class="text-xs text-on-surface-variant font-medium">Showing 4 of 142 applicants</p>
            <div class="flex gap-1">
                <button class="p-2 rounded-lg hover:bg-surface-container transition-colors"><span
                        class="material-symbols-outlined text-lg">chevron_left</span></button>
                <button
                    class="w-8 h-8 flex items-center justify-center bg-primary text-white text-xs font-bold rounded-lg shadow-sm">1</button>
                <button
                    class="w-8 h-8 flex items-center justify-center hover:bg-surface-container text-xs font-bold rounded-lg transition-colors">2</button>
                <button
                    class="w-8 h-8 flex items-center justify-center hover:bg-surface-container text-xs font-bold rounded-lg transition-colors">3</button>
                <button class="p-2 rounded-lg hover:bg-surface-container transition-colors"><span
                        class="material-symbols-outlined text-lg">chevron_right</span></button>
            </div>
        </div>
    </div>


</div>