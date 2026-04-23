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
    // STATISTICS ROUTE
    Route::get('statistics', [App\Http\Controllers\Admin\StatisquesController::class, 'index'])->name('believers.statistics');

    // BELIEVERS CATEGORY ROUTES
    Route::resource('categories', App\Http\Controllers\Admin\BelieversCategoryController::class)->except(['show']);

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

    // TEAM ROUTES
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);

    Route::post('teams/{team}/assign-believer', [App\Http\Controllers\Admin\TeamController::class, 'assignBeliever'])
        ->name('teams.assignBeliever');

    Route::delete('teams/{team}/remove-believer/{believer}', [App\Http\Controllers\Admin\TeamController::class, 'removeBeliever'])
        ->name('teams.removeBeliever');

    Route::get('/teams/{team}/export-excel', [App\Http\Controllers\Admin\TeamController::class, 'exportExcel'])->name('teams.exportExcel');
    Route::get('/teams/{team}/export-pdf', [App\Http\Controllers\Admin\TeamController::class, 'exportPdf'])->name('teams.exportPdf');

    // ACTIVITY PROGRAM ROUTES
    Route::get('/teams/{team}/activities', [App\Http\Controllers\Admin\ActivityProgramController::class, 'index'])->name('teams.activities.index');
    Route::get('/teams/{team}/activities/create', [App\Http\Controllers\Admin\ActivityProgramController::class, 'create'])->name('teams.activities.create');
    Route::post('/teams/{team}/activities', [App\Http\Controllers\Admin\ActivityProgramController::class, 'store'])->name('teams.activities.store');

    Route::get('/teams/{team}/activities/{activity}', [App\Http\Controllers\Admin\ActivityProgramController::class, 'show'])->name('teams.activities.show');
    Route::get('/teams/{team}/activities/{activity}/edit', [App\Http\Controllers\Admin\ActivityProgramController::class, 'edit'])->name('teams.activities.edit');
    Route::put('/teams/{team}/activities/{activity}', [App\Http\Controllers\Admin\ActivityProgramController::class, 'update'])->name('teams.activities.update');
    Route::delete('/teams/{team}/activities/{activity}', [App\Http\Controllers\Admin\ActivityProgramController::class, 'destroy'])->name('teams.activities.destroy');

    // TEAM OBJECTIVE ROUTES
    Route::resource('teams.objectives', App\Http\Controllers\Admin\TeamObjectiveController::class)->except(['show']);

    // TEAM ACTIVITY EXPENSE ROUTES
    Route::prefix('teams/{team}/activities/{activity}')->name('teams.activities.')->group(function () {
        Route::post('/expenses', [App\Http\Controllers\Admin\TeamActivityExpenseController::class, 'store'])->name('expenses.store');
        Route::put('/expenses/{expense}', [App\Http\Controllers\Admin\TeamActivityExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{expense}', [App\Http\Controllers\Admin\TeamActivityExpenseController::class, 'destroy'])->name('expenses.destroy');
    });

    Route::post('/teams/{team}/activities/{activityProgram}/documents', 
        [App\Http\Controllers\Admin\TeamActivityDocumentController::class, 'store']
    )->name('teams.activities.documents.store');

    Route::delete('/teams/{team}/activities/{activityProgram}/documents/{document}', 
        [App\Http\Controllers\Admin\TeamActivityDocumentController::class, 'destroy']
    )->name('teams.activities.documents.destroy');

    Route::get('/admin/teams/{team}/activities/report', 
        [App\Http\Controllers\Admin\ActivityProgramController::class, 'annualReport']
    )->name('teams.activities.annualReport');

    // PERIODES ROUTES
    Route::resource('periodes', App\Http\Controllers\Admin\PeriodeController::class);
    Route::patch('periodes/{periode}/activate', [App\Http\Controllers\Admin\PeriodeController::class, 'activate'])->name('periodes.activate');

    // SERVICES ROUTES
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
});