<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <!-- Header Section -->
<header class="mb-12">
<h1 class="font-headline text-5xl font-extrabold text-on-surface tracking-tighter mb-2">Welcome back, <?= ucwords(Yii::$app->user->identity->username) ?>.</h1>
<p class="text-on-surface-variant font-medium text-lg">Your industrial attachment progress is currently being curated.</p>
</header>
<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Left Column: Application Status & Progress (Col 7) -->
<div class="lg:col-span-7 space-y-8">
<!-- Status Card -->
<section class="bg-surface-container-lowest rounded-xl p-8 shadow-sm ring-1 ring-outline-variant/10">
<div class="flex justify-between items-start mb-10">
<div>
<span class="text-label-sm font-bold uppercase tracking-widest text-primary mb-2 block">Current Status</span>
<h2 class="font-headline text-3xl font-bold text-on-surface">Application Under Review</h2>
</div>
<div class="bg-secondary-fixed text-on-secondary-fixed px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
<span class="material-symbols-outlined text-lg" data-icon="hourglass_empty">hourglass_empty</span>
                            Pending Review
                        </div>
</div>
<!-- Progress Tracker Component -->
<div class="relative py-4">
<div class="absolute top-1/2 left-0 w-full h-1 bg-surface-container-high -translate-y-1/2 rounded-full overflow-hidden">
<div class="w-2/3 h-full primary-gradient rounded-full"></div>
</div>
<div class="relative flex justify-between">
<div class="flex flex-col items-center gap-3">
<div class="w-10 h-10 rounded-full primary-gradient text-on-primary flex items-center justify-center z-10 shadow-lg">
<span class="material-symbols-outlined" data-icon="check" style="font-variation-settings: 'FILL' 0; font-weight: 700;">check</span>
</div>
<span class="text-xs font-bold font-headline text-on-surface">Submitted</span>
</div>
<div class="flex flex-col items-center gap-3">
<div class="w-10 h-10 rounded-full primary-gradient text-on-primary flex items-center justify-center z-10 shadow-lg">
<span class="material-symbols-outlined" data-icon="edit_note">edit_note</span>
</div>
<span class="text-xs font-bold font-headline text-on-surface">Reviewing</span>
</div>
<div class="flex flex-col items-center gap-3">
<div class="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center z-10">
<span class="material-symbols-outlined" data-icon="verified">verified</span>
</div>
<span class="text-xs font-bold font-headline text-outline">Accepted</span>
</div>
<div class="flex flex-col items-center gap-3">
<div class="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center z-10">
<span class="material-symbols-outlined" data-icon="apartment">apartment</span>
</div>
<span class="text-xs font-bold font-headline text-outline">Placed</span>
</div>
</div>
</div>
<div class="mt-12 p-6 bg-surface-container-low rounded-xl flex items-center gap-6">
<div class="w-16 h-16 rounded-lg bg-white flex items-center justify-center shadow-sm overflow-hidden">
<img alt="Company logo" class="w-full h-full object-cover" data-alt="minimalist modern corporate logo of a tech company on white background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkq9VwcIMJmxOUyx3_VcITAaDQD5X2daeUcvSQ-qI6qTfiNJg7u9fYYnFXqt_KU6W4QQZYC3n86SScnemr6Fl29eztx9MDsowMQrFzjJhApQfQezR1NiWiJVB57d3PxYLRRvxZRCcoFTkYV5dHrUEiEjFD6miXhcvpr9IsDFa1PEu08BQQQ-eMoLMjFe73NosyadjH_U1rX0-kKYkzFLMZSECJXoqL9reDROm8udchpTL_3_SEcRuGO79SiRGDqDQeKeSayy9fNM0"/>
</div>
<div>
<h3 class="font-headline font-bold text-on-surface">Nexus Systems Architecture</h3>
<p class="text-sm text-on-surface-variant">Cloud Infrastructure Intern • Nairobi, KE</p>
</div>
<button class="ml-auto text-primary font-bold text-sm hover:underline">View Details</button>
</div>
</section>
<!-- Compliance Documents Section -->
<section class="bg-surface-container-lowest rounded-xl p-8 shadow-sm ring-1 ring-outline-variant/10">
<div class="flex items-center justify-between mb-8">
<div>
<h2 class="font-headline text-2xl font-bold text-on-surface">Compliance Documents</h2>
<p class="text-on-surface-variant text-sm mt-1">Required for institutional approval and insurance.</p>
</div>
<span class="text-label-md font-bold text-tertiary">2 of 4 Complete</span>
</div>
<div class="space-y-4">
<!-- Doc 1: Uploaded -->
<div class="group flex items-center justify-between p-4 bg-surface rounded-xl hover:bg-surface-container-low transition-colors duration-200">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-primary/5 flex items-center justify-center text-primary">
<span class="material-symbols-outlined" data-icon="description">description</span>
</div>
<div>
<h4 class="font-semibold text-on-surface">Application Letter</h4>
<p class="text-xs text-on-surface-variant">PDF, max 2MB</p>
</div>
</div>
<div class="flex items-center gap-4">
<div class="flex items-center gap-1.5 text-green-600 bg-green-50 px-3 py-1 rounded-full text-xs font-bold">
<span class="material-symbols-outlined text-sm" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    Uploaded
                                </div>
<button class="text-outline hover:text-primary transition-colors">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</div>
</div>
<!-- Doc 2: Uploaded -->
<div class="group flex items-center justify-between p-4 bg-surface rounded-xl hover:bg-surface-container-low transition-colors duration-200">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-primary/5 flex items-center justify-center text-primary">
<span class="material-symbols-outlined" data-icon="school">school</span>
</div>
<div>
<h4 class="font-semibold text-on-surface">Letter from School</h4>
<p class="text-xs text-on-surface-variant">Official introduction letter</p>
</div>
</div>
<div class="flex items-center gap-4">
<div class="flex items-center gap-1.5 text-green-600 bg-green-50 px-3 py-1 rounded-full text-xs font-bold">
<span class="material-symbols-outlined text-sm" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    Uploaded
                                </div>
<button class="text-outline hover:text-primary transition-colors">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</div>
</div>
<!-- Doc 3: Missing -->
<div class="group flex items-center justify-between p-4 bg-surface rounded-xl ring-2 ring-error/5 hover:bg-surface-container-low transition-colors duration-200">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-error/5 flex items-center justify-center text-error">
<span class="material-symbols-outlined" data-icon="badge">badge</span>
</div>
<div>
<h4 class="font-semibold text-on-surface">Copy of National ID</h4>
<p class="text-xs text-on-surface-variant">Front and back scan</p>
</div>
</div>
<div class="flex items-center gap-4">
<div class="flex items-center gap-1.5 text-error bg-error-container/20 px-3 py-1 rounded-full text-xs font-bold">
<span class="material-symbols-outlined text-sm" data-icon="error">error</span>
                                    Missing
                                </div>
<button class="primary-gradient text-on-primary px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-transform active:scale-95">
                                    Upload
                                </button>
</div>
</div>
<!-- Doc 4: Missing -->
<div class="group flex items-center justify-between p-4 bg-surface rounded-xl ring-2 ring-error/5 hover:bg-surface-container-low transition-colors duration-200">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-tertiary/5 flex items-center justify-center text-tertiary">
<span class="material-symbols-outlined" data-icon="health_and_safety">health_and_safety</span>
</div>
<div>
<h4 class="font-semibold text-on-surface">Personal Insurance Cover</h4>
<p class="text-xs text-on-surface-variant">Valid student insurance document</p>
</div>
</div>
<div class="flex items-center gap-4">
<div class="flex items-center gap-1.5 text-error bg-error-container/20 px-3 py-1 rounded-full text-xs font-bold">
<span class="material-symbols-outlined text-sm" data-icon="error">error</span>
                                    Missing
                                </div>
<button class="primary-gradient text-on-primary px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-transform active:scale-95">
                                    Upload
                                </button>
</div>
</div>
</div>
</section>
</div>
<!-- Right Column: Quick Stats & Deadlines (Col 5) -->
<div class="lg:col-span-5 space-y-8">
<!-- Deadline Sidebar Card -->
<aside class="bg-primary text-on-primary rounded-xl p-8 shadow-xl relative overflow-hidden">
<div class="absolute top-0 right-0 p-8 opacity-10">
<span class="material-symbols-outlined text-9xl" data-icon="event_available">event_available</span>
</div>
<div class="relative z-10">
<h3 class="font-headline text-2xl font-bold mb-6">Upcoming Milestones</h3>
<div class="space-y-6">
<div class="flex gap-4">
<div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex flex-col items-center justify-center">
<span class="text-[10px] uppercase font-bold">May</span>
<span class="text-lg font-bold">12</span>
</div>
<div>
<p class="font-bold text-lg">Acceptance Deadline</p>
<p class="text-on-primary/70 text-sm">Confirm placement with Nexus Systems</p>
</div>
</div>
<div class="flex gap-4">
<div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex flex-col items-center justify-center">
<span class="text-[10px] uppercase font-bold">Jun</span>
<span class="text-lg font-bold">01</span>
</div>
<div>
<p class="font-bold text-lg">Attachment Start</p>
<p class="text-on-primary/70 text-sm">Orientation at 09:00 AM</p>
</div>
</div>
</div>
<button class="w-full mt-10 bg-white text-primary font-bold py-3 rounded-lg shadow-sm hover:bg-slate-50 transition-colors">
                            View Full Academic Calendar
                        </button>
</div>
</aside>
<!-- Help & Guidance Card -->
<section class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/20">
<h3 class="font-headline text-xl font-bold text-on-surface mb-6">Curated Resources</h3>
<div class="grid grid-cols-1 gap-4">
<a class="flex items-center gap-4 p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow" href="#">
<span class="material-symbols-outlined text-primary" data-icon="menu_book">menu_book</span>
<div>
<p class="font-bold text-sm">Internship Guide</p>
<p class="text-xs text-on-surface-variant">Policies &amp; Expectations</p>
</div>
</a>
<a class="flex items-center gap-4 p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow" href="#">
<span class="material-symbols-outlined text-primary" data-icon="support_agent">support_agent</span>
<div>
<p class="font-bold text-sm">Talk to Advisor</p>
<p class="text-xs text-on-surface-variant">Academic Support Office</p>
</div>
</a>
</div>
<div class="mt-8 rounded-xl overflow-hidden relative group">
<img alt="Students studying" class="w-full h-32 object-cover grayscale group-hover:grayscale-0 transition-all duration-500" data-alt="group of diverse students working collaboratively in a bright modern library space with books and laptops" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQ8YZ_K2SzUhwws5kpsL_NRAwJ5U1LdB-V-o2DxyD8-veMHAIWMg4Ni7oj7LWNbRKe5Uz6P51vdmezKvZC5rHJwrMKJMrHa5MEscvxw5PnzMfOptg89WaN1SdnqD9hLWninvI5eMWvD9D2jvhMEjjeSB9ACm7rSBN_tVSbFZwz23YHhaBdkltOzz1r0AVQUD-k-n6SFC6Vbqfnvw0B_wul7W9-YF-J2nhbTQsb3gEKnAZG1xj_EGekxjf4qm2gQbABHWSGXG00wVY"/>
<div class="absolute inset-0 bg-primary/40 flex items-center justify-center">
<span class="text-white font-bold text-sm">Join Student Forum</span>
</div>
</div>
</section>
</div>
</div>
</div>
