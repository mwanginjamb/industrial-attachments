<?php

$this->title = 'AdminDashboard';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="lot-dashboard">

<!-- Main Content Area -->
<div class="flex-1 ml-98 flex flex-col min-h-screen">

<!-- Content Canvas -->
<main class="p-8 max-w-screen-2xl mx-auto w-full flex-1">
<!-- Page Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
<div>
<nav class="flex items-center gap-2 text-xs text-on-surface-variant font-medium mb-3">
<span class="hover:text-primary cursor-pointer">Admin</span>
<span class="material-symbols-outlined text-[10px]" data-icon="chevron_right">chevron_right</span>
<span class="text-on-surface">Admission Lots</span>
</nav>
<h1 class="text-5xl font-extrabold tracking-tight text-on-surface mb-2">Admission Lots</h1>
<p class="text-on-surface-variant max-w-md">Manage institutional enrollment cycles and application batches with automated deadline tracking.</p>
</div>
<button class="bg-gradient-to-br from-primary to-primary-container text-on-primary px-8 py-4 rounded-xl font-bold flex items-center gap-2 shadow-xl shadow-primary/20 hover:-translate-y-1 transition-all active:scale-95">
<span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                    Create New Lot
                </button>
</div>
<!-- Bento Filter & Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
<!-- Search & Filters -->
<div class="md:col-span-3 bg-surface-container-low p-6 rounded-2xl flex flex-wrap items-center gap-4">
<div class="flex-1 min-w-[240px] relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
<input class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border-none rounded-xl text-sm shadow-sm" placeholder="Filter by lot name or faculty..." type="text"/>
</div>
<div class="flex items-center gap-2">
<button class="flex items-center gap-2 px-4 py-3 bg-surface-container-lowest text-sm font-semibold rounded-xl text-on-surface-variant shadow-sm hover:bg-surface-bright transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="calendar_today">calendar_today</span>
                            All Dates
                        </button>
<button class="flex items-center gap-2 px-4 py-3 bg-surface-container-lowest text-sm font-semibold rounded-xl text-on-surface-variant shadow-sm hover:bg-surface-bright transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="filter_list">filter_list</span>
                            Status
                        </button>
</div>
</div>
<!-- Mini Stats Card -->
<div class="bg-primary-fixed p-6 rounded-2xl flex flex-col justify-between border-none">
<div class="flex justify-between items-start">
<span class="text-on-primary-fixed text-xs font-bold uppercase tracking-widest">Active Lots</span>
<span class="material-symbols-outlined text-primary" data-icon="rocket_launch">rocket_launch</span>
</div>
<div class="mt-4">
<span class="text-4xl font-black text-on-primary-fixed">12</span>
<p class="text-xs text-on-primary-fixed-variant mt-1">+2 from last month</p>
</div>
</div>
</div>
<!-- Data Table Section -->
<div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm ring-1 ring-outline-variant/10">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Lot Name</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Date Created</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Capacity</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-center">Status</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<!-- Row 1 -->
<tr class="hover:bg-surface-container-low/50 transition-colors">
<td class="px-8 py-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">Fall 2024 Undergraduate Intake</span>
<span class="text-xs text-on-surface-variant">Faculty of Engineering</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-on-surface-variant">Sept 12, 2023</td>
<td class="px-8 py-6">
<div class="w-full max-w-[120px]">
<div class="flex justify-between text-[10px] font-bold mb-1">
<span>75%</span>
<span class="text-outline">450/600</span>
</div>
<div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary rounded-full w-[75%]"></div>
</div>
</div>
</td>
<td class="px-8 py-6 text-center">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-secondary-fixed text-on-secondary-fixed">
<span class="h-1.5 w-1.5 rounded-full bg-primary mr-2"></span>
                                    Active
                                </span>
</td>
<td class="px-8 py-6 text-right">
<div class="flex justify-end gap-2">
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg" data-icon="edit">edit</span></button>
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg" data-icon="more_vert">more_vert</span></button>
</div>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-surface-container-low/50 transition-colors">
<td class="px-8 py-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">Summer Internship 2024</span>
<span class="text-xs text-on-surface-variant">Career Services Unit</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-on-surface-variant">Oct 05, 2023</td>
<td class="px-8 py-6">
<div class="w-full max-w-[120px]">
<div class="flex justify-between text-[10px] font-bold mb-1">
<span>20%</span>
<span class="text-outline">40/200</span>
</div>
<div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary rounded-full w-[20%]"></div>
</div>
</div>
</td>
<td class="px-8 py-6 text-center">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-secondary-fixed text-on-secondary-fixed">
<span class="h-1.5 w-1.5 rounded-full bg-primary mr-2"></span>
                                    Active
                                </span>
</td>
<td class="px-8 py-6 text-right">
<div class="flex justify-end gap-2">
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg" data-icon="edit">edit</span></button>
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg" data-icon="more_vert">more_vert</span></button>
</div>
</td>
</tr>
<!-- Row 3 (Inactive) -->
<tr class="hover:bg-surface-container-low/50 transition-colors opacity-70">
<td class="px-8 py-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">Spring 2024 Masters Bridge</span>
<span class="text-xs text-on-surface-variant">Graduate Studies</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-on-surface-variant">July 22, 2023</td>
<td class="px-8 py-6">
<div class="w-full max-w-[120px]">
<div class="flex justify-between text-[10px] font-bold mb-1">
<span>100%</span>
<span class="text-outline">150/150</span>
</div>
<div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-outline rounded-full w-[100%]"></div>
</div>
</div>
</td>
<td class="px-8 py-6 text-center">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-surface-container-high text-on-surface-variant">
<span class="h-1.5 w-1.5 rounded-full bg-outline mr-2"></span>
                                    Inactive
                                </span>
</td>
<td class="px-8 py-6 text-right">
<div class="flex justify-end gap-2">
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg" data-icon="visibility">visibility</span></button>
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg" data-icon="more_vert">more_vert</span></button>
</div>
</td>
</tr>
</tbody>
</table>
<div class="p-6 bg-surface-container-low/30 flex justify-between items-center">
<span class="text-xs text-on-surface-variant font-medium">Showing 3 of 42 admission lots</span>
<div class="flex gap-2">
<button class="p-2 border border-outline-variant/20 rounded-lg hover:bg-surface-container transition-colors disabled:opacity-30" disabled="">
<span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
</button>
<button class="p-2 border border-outline-variant/20 rounded-lg hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Footer Section -->
</div>