<?php

use Illuminate\Support\Facades\Route;

// AUTHENTICATION ROUTES
Route::get('/', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Route::post('/auth_login', [App\Http\Controllers\Auth\AuthController::class, 'auth_login'])->middleware('throttle:login')->name('auth_login');
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/change-password', [App\Http\Controllers\Auth\PasswordController::class, 'show'])
        ->name('password.change');

    Route::post('/change-password', [App\Http\Controllers\Auth\PasswordController::class, 'update'])
        ->name('password.update');
});


// DASHBOARD ROUTE
Route::middleware(['auth', 'force.password.change', 'ensure.user.active', 'auto.logout'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('menu.dashboard');

    // BELIEVERS CATEGORY ROUTES
    Route::resource('categories', App\Http\Controllers\Admin\BelieversCategoryController::class)->except(['show']);
    Route::get('believers/stats', [App\Http\Controllers\Admin\StatsController::class, 'index'])->name('believers.stats');

    // SEARCH BELIEVERS ROUTE
    Route::get('believers/search', [App\Http\Controllers\Admin\BelieverController::class, 'search'])->name('believers.search');
    // DISCIPLINARY SANCTIONS ROUTE
    Route::get('believers/sanctions', [App\Http\Controllers\Admin\BelieverController::class, 'disciplinarySanction'])->name('believers.sanctions');
    // DEPARTED BELIEVERS ROUTE
    Route::get('believers/departures', [App\Http\Controllers\Admin\BelieverController::class, 'departures'])->name('believers.departures');
    // BELIEVERS ROUTES
    Route::resource('believers', App\Http\Controllers\Admin\BelieverController::class);
    // BILIEVERS PDF GENERATION ROUTE
    Route::get('believers/{believer}/generate-pdf', [App\Http\Controllers\Admin\BelieverController::class, 'generatePdf'])->name('believers.generate_pdf');
    // BELIEVERS EXCEL EXPORT ROUTE
    Route::get('believers/export/excel', [App\Http\Controllers\Admin\BelieverController::class, 'exportExcel'])->name('believers.export_excel');
    // BELIEVERS EXCEL IMPORT ROUTE
    Route::post('believers/import/excel', [App\Http\Controllers\Admin\BelieverController::class, 'importExcel'])->name('believers.import_excel');
    // BELIEVERS IMPORT TEMPLATE DOWNLOAD ROUTE
    Route::get('believers/import/template', [App\Http\Controllers\Admin\BelieverController::class, 'downloadImportTemplate'])->name('believers.download_import_template');
    // DISCIPLINARY ACTION ROUTES
    Route::post('believers/{believer}/discipline', [App\Http\Controllers\Admin\BelieverController::class, 'applyDiscipline'])->name('believers.applyDiscipline');
    Route::patch('believers/{believer}/discipline/lift-discipline', [App\Http\Controllers\Admin\BelieverController::class, 'liftDiscipline'])->name('believers.liftDiscipline');
    // BELIEVER DEPARTURE ROUTE
    Route::post('believers/{believer}/leave', [App\Http\Controllers\Admin\BelieverController::class, 'leave'])->name('believers.leave');
    Route::patch('believers/{believer}/reintegrate', [App\Http\Controllers\Admin\BelieverController::class, 'reintegrate'])->name('believers.reintegrate');

    // USER MANAGEMENT ROUTES
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::post('users/{user}/deactivate', [App\Http\Controllers\Admin\UserController::class, 'deactivate'])->name('users.deactivate');
    Route::patch('users/{user}/reactivate', [App\Http\Controllers\Admin\UserController::class, 'reactivate'])->name('users.reactivate');
    // LOGIN HISTORY ROUTE
    Route::get('login-histories', [App\Http\Controllers\Admin\LoginHistoryController::class, 'index'])->name('login.histories');


    // ROLE MANAGEMENT ROUTES
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class)->except(['show']);


    // CHURCH INFO ROUTES
    Route::resource('church_info', App\Http\Controllers\Admin\ChurchInfoController::class);

    // FUNERAL REGISTER ROUTES
    Route::resource('funerals', App\Http\Controllers\Admin\FuneralRegisterController::class);
    // GENERATE FUNERAL PDF ROUTE
    Route::get('funerals/{funeral}/generate-pdf', [App\Http\Controllers\Admin\FuneralRegisterController::class, 'generatePdf'])->name('funerals.pdf');

    // CHILD DEDICATION ROUTES
    Route::resource('child_dedications', App\Http\Controllers\Admin\ChildDedicationController::class);
    // GENERATE CHILD DEDICATION PDF ROUTE
    Route::get('child_dedications/{child_dedication}/generate-pdf', [App\Http\Controllers\Admin\ChildDedicationController::class, 'generatePdf'])->name('child_dedications.generate_pdf');

    // MARIAGE REGISTER ROUTES
    Route::resource('mariages', App\Http\Controllers\Admin\MariageRegisterController::class);
    // GENERATE MARIAGE REGISTER PDF ROUTE
    Route::get('mariages/{mariage}/generate-pdf', [App\Http\Controllers\Admin\MariageRegisterController::class, 'generatePdf'])->name('mariages.generate_pdf');

    // PROGRAM ROUTES
    Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);

    // STATISTICS ROUTE
    Route::get('statistics', [App\Http\Controllers\Admin\StatisquesController::class, 'index'])->name('believers.statistics');

    // GROUPS ROUTES
    Route::resource('groups', App\Http\Controllers\Admin\GroupController::class);
    Route::post('groups/{group}/assign-believer', [App\Http\Controllers\Admin\GroupController::class, 'assignBeliever'])
        ->name('groups.assignBeliever');

    Route::delete('groups/{group}/remove-believer/{believer}', [App\Http\Controllers\Admin\GroupController::class, 'removeBeliever'])
        ->name('groups.removeBeliever');
    
    Route::get('groups/{group}/export-excel', [App\Http\Controllers\Admin\GroupController::class, 'exportMembersExcel'])
    ->name('groups.exportExcel');

    Route::get('groups/{group}/export-pdf', [App\Http\Controllers\Admin\GroupController::class, 'exportMembersPdf'])
        ->name('groups.exportPdf');
});