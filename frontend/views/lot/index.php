<?php

use frontend\models\lot;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LotSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lots';
$this->params['breadcrumbs'][] = $this->title;

$params = Yii::$app->request->get('LotSearch', []);
?>
<div class="lot-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>




    <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm ring-1 ring-black/5">

        <!-- Header -->
        <div class="px-8 py-6 flex items-center justify-between bg-surface-container-low">
            <h3 class="font-bold text-lg text-blue-900">Active Intake Cycles</h3>

            <div class="flex gap-2">
                <!-- Add Lot Link (lot/create) -->
                <?= Html::a('Create Lot', ['create'], ['class' => 'px-4 py-2 bg-primary text-white font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center justify-center gap-2']) ?>
                <button
                    class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined">filter_list</span>
                </button>
                <button
                    class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined">more_vert</span>
                </button>

            </div>
        </div>

        <!-- Search form -->
        <form method="get" class="px-8 py-4 flex items-center gap-3 bg-surface-container-low border-b border-black/5">

            <input type="text" name="LotSearch[description]" value="<?= Html::encode($params['description'] ?? '') ?>"
                placeholder="Search lot description..."
                class="px-4 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 outline-none text-sm w-64">

            <select name="LotSearch[status]" class="px-5 py-2 rounded-lg border border-slate-200 text-sm">
                <option value="">All Status</option>
                <option value="active" <?= ($params['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($params['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive
                </option>
            </select>

            <button class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Search
            </button>

            <!-- Reset -->
            <a href="<?= \yii\helpers\Url::to(['index']) ?>" class="text-sm text-on-surface-variant hover:underline">
                Reset
            </a>

        </form>

        <!-- Grid -->
        <div class="overflow-x-auto">
            <?= GridView::widget([

                'dataProvider' => $dataProvider,
                'filterModel' => null,

                'layout' => "{items}\n<div class='px-8 py-4 bg-surface-container-low/50 flex justify-between items-center text-xs font-bold text-on-surface-variant'>{summary}<div>{pager}</div></div>",

                'emptyText' => '<div class="px-8 py-10 text-center text-on-surface-variant">No intake cycles found.</div>',

                'tableOptions' => [
                    'class' => 'w-full text-left border-collapse',
                ],

                'headerRowOptions' => [
                    'class' => 'bg-surface-container-low/50'
                ],

                // 🔥 ACTIVE ROW HIGHLIGHT FIXED
                'rowOptions' => function ($model, $key, $index) {

                                $base = $index % 2 === 0
                                    ? 'group hover:bg-surface-container-low/30 transition-colors'
                                    : 'bg-surface-container-low group hover:bg-surface-container-high/50 transition-colors';

                                if ($model->isActive) {
                                    return ['class' => $base . ' ring-1 ring-primary/20 bg-primary/5'];
                                }

                                return ['class' => $base];
                            },

                'columns' => [

                    // LOT NAME
                    [
                        'attribute' => 'description',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'px-8 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant'],
                        'contentOptions' => ['class' => 'px-8 py-6'],
                        'value' => function ($model) use ($searchModel) {

                                        $text = Html::encode($model->description);

                                        if ($searchModel->description) {
                                            $safeSearch = Html::encode($searchModel->description);

                                            $text = str_ireplace(
                                                $safeSearch,
                                                '<span class="bg-yellow-200 px-1 rounded">' . $safeSearch . '</span>',
                                                $text
                                            );
                                        }

                                        return '
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-blue-50 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined" style="font-variation-settings: \'FILL\' 1;">folder</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface">' . $text . '</p>
                                <p class="text-xs text-on-surface-variant">Industrial Attachment</p>
                            </div>
                        </div>';
                                    }
                    ],

                    // DATE RANGE
                    [
                        'label' => 'Date Range',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant'],
                        'contentOptions' => ['class' => 'px-6 py-6 text-sm text-on-surface-variant font-medium'],
                        'value' => fn($model) =>
                            date('M d, Y', strtotime($model->opening_date)) . ' - ' .
                            date('M d, Y', strtotime($model->closing_date)),
                    ],

                    // STATUS
                    [
                        'label' => 'Status',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant'],
                        'contentOptions' => ['class' => 'px-6 py-6'],
                        'value' => fn($model) =>
                            $model->isactive
                            ? '<span class="px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[11px] font-bold uppercase tracking-wider">Active</span>'
                            : '<span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[11px] font-bold uppercase tracking-wider">Inactive</span>'
                    ],

                    // APPLICATIONS
                    [
                        'label' => 'Applications',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant'],
                        'contentOptions' => ['class' => 'px-6 py-6'],
                        'value' => function ($model) {

                                        $count = $model->applicationsCount;

                                        return '
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-on-surface">' . $count . '</span>
                            <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="bg-primary h-full" style="width:60%"></div>
                            </div>
                        </div>';
                                    }
                    ],

                    // ACTION
                    [
                        'label' => '',
                        'format' => 'raw',
                        'headerOptions' => [
                            'class' => 'px-8 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right'
                        ],
                        'contentOptions' => [
                            'class' => 'px-8 py-6 text-right'
                        ],
                        'value' => function ($model) {

                                        $view = Html::a(
                                            '<span class="material-symbols-outlined text-sm">visibility</span>',
                                            ['lot/view', 'id' => $model->id],
                                            [
                                                'class' => 'p-2 rounded-lg hover:bg-surface-container-high transition inline-flex items-center text-on-surface-variant',
                                                'title' => 'View Applications'
                                            ]
                                        );

                                        $update = '';

                                        // ✅ ONLY show update if NOT active
                                        if (!$model->isActive) {
                                            $update = Html::a(
                                                '<span class="material-symbols-outlined text-sm">edit</span>',
                                                ['lot/update', 'id' => $model->id],
                                                [
                                                    'class' => 'p-2 rounded-lg hover:bg-surface-container-high transition inline-flex items-center text-on-surface-variant',
                                                    'title' => 'Update Lot'
                                                ]
                                            );
                                        }

                                        return '
            <div class="flex justify-end gap-2">
                ' . $view . '
                ' . $update . '
            </div>
        ';
                                    }
                    ]
                ],

                'pager' => [
                    'options' => ['class' => 'flex gap-1'],
                    'linkOptions' => ['class' => 'w-8 h-8 flex items-center justify-center rounded hover:bg-white transition-all text-on-surface-variant'],
                    'activePageCssClass' => 'bg-white shadow-sm ring-1 ring-black/5 text-primary',
                ],

            ]); ?>
        </div>
    </div>


</div>