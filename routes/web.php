<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/wizard-demo', function () {
    return Inertia::render('WizardDemo');
})->middleware(['auth', 'verified'])->name('wizard.demo');

Route::get('/demo/users', function () {
    return Inertia::render('Demo/UsersIndex');
})->middleware(['auth', 'verified'])->name('demo.users');

// --- PREMIUM ADMIN OPTIONS ROUTING ---
Route::middleware(['auth', 'verified'])->prefix('demo')->group(function () {
    // Dashboards
    Route::get('/dashboard-v2', function () { return Inertia::render('Demo/DashboardV2'); })->name('dashboard.v2');
    Route::get('/dashboard-v3', function () { return Inertia::render('Demo/DashboardV3'); })->name('dashboard.v3');

    // Custom Tools
    Route::get('/theme-generate', function () { return Inertia::render('Demo/ThemeGenerate'); })->name('theme.generate');
    Route::get('/widgets', function () { return Inertia::render('Demo/Widgets'); })->name('widgets');
    Route::get('/layout-options', function () { return Inertia::render('Demo/LayoutOptions'); })->name('layout.options');

    // UI Elements
    Route::get('/ui/general', function () { return Inertia::render('Demo/UI/General'); })->name('ui.general');
    Route::get('/ui/icons', function () { return Inertia::render('Demo/UI/Icons'); })->name('ui.icons');
    Route::get('/ui/buttons', function () { return Inertia::render('Demo/UI/Buttons'); })->name('ui.buttons');
    Route::get('/ui/sliders', function () { return Inertia::render('Demo/UI/Sliders'); })->name('ui.sliders');
    Route::get('/ui/modals-alerts', function () { return Inertia::render('Demo/UI/ModalsAlerts'); })->name('ui.modals-alerts');
    Route::get('/ui/cards', function () { return Inertia::render('Demo/UI/Cards'); })->name('ui.cards');
    Route::get('/ui/timeline', function () { return Inertia::render('Demo/UI/Timeline'); })->name('ui.timeline');

    // Mailbox
    Route::get('/mailbox/inbox', function () { return Inertia::render('Demo/Mailbox/Inbox'); })->name('mailbox.inbox');
    Route::get('/mailbox/compose', function () { return Inertia::render('Demo/Mailbox/Compose'); })->name('mailbox.compose');
    Route::get('/mailbox/read', function () { return Inertia::render('Demo/Mailbox/Read'); })->name('mailbox.read');

    // Forms
    Route::get('/forms/general', function () { return Inertia::render('Demo/Forms/GeneralForms'); })->name('forms.general');
    Route::get('/forms/advanced', function () { return Inertia::render('Demo/Forms/AdvancedForms'); })->name('forms.advanced');
    Route::get('/forms/validation', function () { return Inertia::render('Demo/Forms/ValidationForms'); })->name('forms.validation');

    // Tables
    Route::get('/tables/simple', function () { return Inertia::render('Demo/Tables/SimpleTables'); })->name('tables.simple');
    Route::get('/tables/datatables', function () { return Inertia::render('Demo/Tables/DataTables'); })->name('tables.datatables');

    // Pages
    Route::get('/pages/invoice', function () { return Inertia::render('Demo/Pages/Invoice'); })->name('pages.invoice');
    Route::get('/pages/pricing', function () { return Inertia::render('Demo/Pages/Pricing'); })->name('pages.pricing');
    Route::get('/pages/faq', function () { return Inertia::render('Demo/Pages/Faq'); })->name('pages.faq');
    Route::get('/pages/error', function () { return Inertia::render('Demo/Pages/Error404'); })->name('pages.error');

    // Auth Mocks
    Route::get('/auth/login', function () { return Inertia::render('Demo/Auth/LoginMock'); })->name('auth.login.mock');
    Route::get('/auth/register', function () { return Inertia::render('Demo/Auth/RegisterMock'); })->name('auth.register.mock');
    Route::get('/auth/forgot-password', function () { return Inertia::render('Demo/Auth/ForgotPasswordMock'); })->name('auth.forgot-password.mock');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Menu Builder Routes
    Route::get('/admin/menus', [MenuController::class, 'index'])->name('admin.menus.index');
    Route::post('/admin/menus', [MenuController::class, 'store'])->name('admin.menus.store');
    Route::put('/admin/menus/{menuItem}', [MenuController::class, 'update'])->name('admin.menus.update');
    Route::delete('/admin/menus/{menuItem}', [MenuController::class, 'destroy'])->name('admin.menus.destroy');
    Route::post('/admin/menus/reorder', [MenuController::class, 'reorder'])->name('admin.menus.reorder');
});

require __DIR__.'/auth.php';
