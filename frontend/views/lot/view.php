<?php

use yii\helpers\Html;
use frontend\assets\ApplicantsAsset;


/** @var yii\web\View $this */
/** @var app\models\lot $model */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
ApplicantsAsset::register($this);

$selected = <<<ICO
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
ICO;

// Get the current absolute URL dynamically
$currentUrl = Yii::$app->request->absoluteUrl . '&selection=' . $model->id;
// Construct the structured email body using double quotes for \n to work
$emailBody = "Dear Colleagues,\n\n"
    . "please access this list and select suitable candidates.\n\n"
    . "Link: " . Html::encode($currentUrl) . "\n\n"
    . "Regards,\n"
    . "HR Team";
?>
<div class="lot-view">

    <!-- header div -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-4xl font-extrabold tracking-tight text-on-surface"><?= Html::encode($this->title) ?></h1>


            <div class="grid grid-cols-1 md:grid-cols-4 gap-1 mb-10">
                <span class="text-green-600 text-sm font-medium">Application Start Date:
                    <?= Yii::$app->formatter->asDate($model->applicationStartDate) ?></span>
                <span class="text-error text-sm font-medium">Application End Date:
                    <?= Yii::$app->formatter->asDate($model->applicationDeadline) ?></span>
                <span class="text-on-surface-variant text-sm font-medium">Processing Deadline:
                    <?= Yii::$app->formatter->asDate($model->placementDeadline) ?></span>
            </div>
        </div>
        <div class="flex gap-3">
            <?php Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php Html::a('Delete', ['delete', 'id' => $model->id], [
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
                <span class="text-green-600 text-xs font-bold ml-2"></span>
            </div>
        </div>
        <div class="md:col-span-1 bg-surface-container-low p-6 rounded-xl flex flex-col justify-between">
            <span class="text-on-surface-variant text-sm font-medium">Pending Review</span>
            <div class="mt-4">
                <span class="text-3xl font-black text-on-surface"><?= $model->reviewedCount ?></span>
            </div>
        </div>
        <div
            class="md:col-span-2 bg-primary-container p-6 rounded-xl flex items-center justify-between text-on-primary-container relative overflow-hidden">
            <div class="z-10">
                <span class="text-sm font-medium opacity-80">Processing Status</span>
                <h3 class="text-2xl font-bold mt-1">Batch
                    <?= Yii::$app->formatter->asPercent($model->percentageReviewed, 1) ?> Complete
                </h3>
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
                <!-- <button
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border-none bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">filter_list</span> Filter
                </button> -->
                <?=
                    (Yii::$app->request->get('placement') !== null) ?
                    yii\helpers\Html::a(
                        '<span class="material-symbols-outlined text-lg">mail</span> Email Department',
                        'mailto:staff@kemri.go.ke?subject=Candidate%20Selection&body=' . rawurlencode($emailBody),
                        [
                            'id' => 'btnMailCandidates',
                            'class' => 'btn-mail-candidates inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold border-none bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors no-underline'
                        ]
                    )
                    : '';
                ?>
                <button id="btnExportExcel"
                    class="btn-export-excel flex items-center gap-2 px-4 py-2 text-sm font-semibold border-none bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">download</span> Export
                </button>
            </div>
        </div>


        <!-- Search form -->
        <form method="get" class="px-8 py-4 flex items-center gap-3 bg-surface-container-low border-b border-black/5">
            <label for="placement">Filter By Placement Area</label>
            <input type="hidden" name="id" value="<?= $model->id ?? '' ?>">
            <?php if (count($pas)): ?>
                <select name="placement" id="placement" class="px-5 py-2 rounded-lg border border-slate-200 text-sm">
                    <?php foreach ($pas as $pa): ?>

                        <option value="<?= $pa->id ?>" <?= ($params['placement'] ?? '') === $pa->id ? 'selected' : '' ?>>
                            <?= $pa->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <button class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Search
            </button>

            <!-- Reset -->
            <a href="<?= \yii\helpers\Url::to(['view', 'id' => $model->id]) ?>"
                class="text-sm text-on-surface-variant hover:underline">
                Reset
            </a>

        </form>


        <div class="overflow-x-auto">
            <table class="w-full text-left font-['Inter']" id="applicantsList">
                <thead>
                    <tr
                        class="bg-surface-container-low text-on-surface-variant uppercase text-[10px] font-black tracking-widest">
                        <th class="px-8 py-4" data-priority="1">Name &amp; ID</th>
                        <th class="px-6 py-4" data-priority="2">Year</th>
                        <th class="px-6 py-4" data-priority="3">Level</th>
                        <th class="px-6 py-4" data-priority="4">Institution</th>
                        <th class="px-6 py-4 text-success" data-priority="5">Preferred Placement</th>
                        <th class="px-6 py-4 text-success" data-priority="6">Selected</th>
                        <th class="px-6 py-4" data-priority="7">Status</th>
                        <th class="px-8 py-4 text-right" data-priority="8">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    <?php foreach ($applications as $application):
                        if ($application?->attachee?->name == null)
                            continue;
                        $endpoint = \yii\helpers\Url::home(true) . 'apiv1/applications/' . $application->id;
                        ?>
                        <!-- Row 1 -->
                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                        <?= ($application?->attachee?->name) ? strtoupper(substr($application?->attachee?->name, 0, 1)) : '' ?>
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
                            </td>
                            <td class="px-6 py-5 text-sm">
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
        <!-- / Table Div -->

    </div>


</div>


<?php

$style = <<<CSS

/* ==========================================================
   Remove default DataTables appearance
========================================================== */

div.dt-container,
div.dt-layout-row,
div.dt-layout-cell {
    background: transparent !important;
    border: none !important;
    font-family: 'Inter', sans-serif;
}

table.dataTable,
table.dataTable.no-footer,
table.dataTable thead th,
table.dataTable thead td {
    border: none !important;
}

table.dataTable tbody td {
    border-bottom: 1px solid rgb(0 0 0 / 0.05) !important;
}

/* ==========================================================
   Top controls row
========================================================== */

div.dt-layout-row:first-child {
    display: flex !important;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.25rem 2rem;
    background: rgb(var(--surface-container-low));
    border-bottom: 1px solid rgb(0 0 0 / 0.05);
}

/* Left side */

div.dt-length {
    display: flex;
    align-items: center;
    gap: .5rem;
}

div.dt-length label {
    display: flex;
    align-items: center;
    gap: .5rem;
    color: rgb(var(--on-surface-variant));
    font-size: .875rem;
    font-weight: 500;
}

/* Entries dropdown */

div.dt-length select {
    appearance: none;
    padding: .5rem 2.5rem .5rem .75rem;
    border-radius: .75rem;
    border: 1px solid rgb(226 232 240);
    background: white;
    font-size: .875rem;
    min-width: 80px;
    transition: all .15s ease;
}

div.dt-length select:hover {
    border-color: rgb(148 163 184);
}

div.dt-length select:focus {
    outline: none;
    border-color: rgb(59 130 246);
    box-shadow: 0 0 0 3px rgb(59 130 246 / .15);
}

/* ==========================================================
   Search box
========================================================== */

div.dt-search {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-left: auto;
}

div.dt-search label {
    color: rgb(var(--on-surface-variant));
    font-size: .875rem;
    font-weight: 500;
}

div.dt-search input {
    width: 260px;
    padding: .625rem 1rem;
    border-radius: .75rem;
    border: 1px solid rgb(226 232 240);
    background: white;
    font-size: .875rem;
    transition: all .15s ease;
}

div.dt-search input::placeholder {
    color: rgb(148 163 184);
}

div.dt-search input:hover {
    border-color: rgb(148 163 184);
}

div.dt-search input:focus {
    outline: none;
    border-color: rgb(59 130 246);
    box-shadow: 0 0 0 3px rgb(59 130 246 / .15);
}

/* ==========================================================
   Bottom row
========================================================== */

div.dt-layout-row:last-child {
    display: flex !important;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.5rem 2rem;
}

/* Info text */

div.dt-info {
    color: rgb(var(--on-surface-variant));
    font-size: .875rem;
    font-weight: 500;
}

/* ==========================================================
   Pagination
========================================================== */

div.dt-paging {
    display: flex;
    gap: .25rem;
    align-items: center;
}

div.dt-paging .dt-paging-button {
    display: inline-flex !important;
    justify-content: center;
    align-items: center;

    width: 2rem;
    height: 2rem;

    border: none !important;
    border-radius: .75rem !important;

    background: transparent !important;

    color: rgb(var(--on-surface));
    font-size: .75rem;
    font-weight: 700;

    transition: all .15s ease;
}

div.dt-paging .dt-paging-button:hover:not(.disabled) {
    background: rgb(var(--surface-container)) !important;
}

div.dt-paging .dt-paging-button.current,
div.dt-paging .dt-paging-button.current:hover {
    background: rgb(var(--primary)) !important;
    color: white !important;
    box-shadow:
        0 1px 2px rgb(0 0 0 / .08),
        0 1px 3px rgb(0 0 0 / .12);
}

div.dt-paging .dt-paging-button.disabled {
    opacity: .35;
    cursor: not-allowed;
}

/* ==========================================================
   Header sorting
========================================================== */

table.dataTable thead th.dt-orderable-asc,
table.dataTable thead th.dt-orderable-desc {
    cursor: pointer;
    transition: background .15s ease;
}

table.dataTable thead th.dt-orderable-asc:hover,
table.dataTable thead th.dt-orderable-desc:hover {
    background: rgb(var(--surface-container));
}

/* ==========================================================
   Responsive
========================================================== */

@media (max-width: 768px) {

    div.dt-layout-row:first-child,
    div.dt-layout-row:last-child {
        flex-direction: column;
        align-items: stretch;
    }

    div.dt-search {
        margin-left: 0;
    }

    div.dt-search input {
        width: 100%;
    }

    div.dt-paging {
        justify-content: center;
    }
}


/* Top DataTables toolbar row */
div.dt-layout-row:first-child {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1rem 2rem;
}

/* Make left and right containers behave correctly */
div.dt-layout-row:first-child .dt-layout-cell {
    display: flex;
    align-items: center;
}

/* Push search to the far right */
div.dt-layout-row:first-child .dt-layout-cell.dt-layout-end {
    margin-left: auto;
}

/* Length selector layout */
div.dt-length {
    display: flex;
    align-items: center;
    gap: .5rem;
}

div.dt-length label {
    display: flex !important;
    align-items: center;
    gap: .5rem;
    margin: 0 !important;
}

/* Search layout */
div.dt-search {
    display: flex;
    align-items: center;
    gap: .75rem;
}

div.dt-search label {
    display: flex !important;
    align-items: center;
    gap: .5rem;
    margin: 0 !important;
}

/* Search input styling */
div.dt-search input {
    width: 280px !important;
    padding: .625rem .875rem !important;
    border-radius: .5rem !important;
    border: 1px solid #d1d5db !important;
    background: white !important;
}

/* Entries dropdown styling */
div.dt-length select {
    padding: .5rem 2rem .5rem .75rem !important;
    border-radius: .5rem !important;
    border: 1px solid #d1d5db !important;
    background: white !important;
}
CSS;
$this->registerCss($style);

$script = <<<JS

$(document).ready(function() {
        var table = $('#applicantsList').DataTable({
        responsive: true,
        paging: true,
        ordering: true,
        searching: true,
        info: true,

        pageLength: 10,

        lengthMenu: [
            [10,25,50,-1],
            [10,25,50,'All']
        ],

        layout: {
            topStart: 'pageLength',
            topEnd: 'search',
            bottomStart: 'info',
            bottomEnd: 'paging'
        },

        language: {
            search: '',
            searchPlaceholder: 'Search applicants...',
            lengthMenu: '_MENU_ entries per page',
            info: 'Showing _START_ to _END_ of _TOTAL_ applicants',
            zeroRecords: 'No matching applicants found'
        }
    });

    $('#btnExportExcel').on('click', function () {

    var rows = [];

    // headers
    var headers = [];

    table.columns().header().each(function(header){
        headers.push($(header).text().trim());
    });

    rows.push(headers.join(','));

    // export filtered rows
    table.rows({ search: 'applied' }).every(function () {

            var data = [];

            $(this.node()).find('td').each(function () {
                var text = $(this).text().trim().replace(/\s+/g,' ');

                if(text.includes(',')) {
                    text = '"' + text + '"';
                }

                data.push(text);
            });

            rows.push(data.join(','));
        });

        var csv = rows.join('\\n');

        var blob = new Blob(
            ['\uFEFF' + csv],
            {type:'text/csv;charset=utf-8;'}
        );

        var link = document.createElement('a');

        link.href = URL.createObjectURL(blob);
        link.download = 'applicants_list.csv';

        link.click();

        URL.revokeObjectURL(link.href);
    });
});
JS;

$this->registerJs($script, \yii\web\View::POS_END);




?>