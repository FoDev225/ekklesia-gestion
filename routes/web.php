<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [
    App\Http\Controllers\Auth\AuthController::class,
    'login'
])->name('login');

Route::post('/auth_login', [
    App\Http\Controllers\Auth\AuthController::class,
    'auth_login'
])->middleware('throttle:login')->name('auth_login');

Route::post('/logout', [
    App\Http\Controllers\Auth\AuthController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| PASSWORD CHANGE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/change-password', [
        App\Http\Controllers\Auth\PasswordController::class,
        'show'
    ])->name('password.change');

    Route::post('/change-password', [
        App\Http\Controllers\Auth\PasswordController::class,
        'update'
    ])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| USER REDIRECTION AFTER LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/redirect-user', function () {

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    */
    if ($user->hasAnyRole(['pasteur', 'secretariat'])) {

        return redirect()->route('admin.believers.statistics');
    }

    /*
    |--------------------------------------------------------------------------
    | DIRECTION DES CULTES
    |--------------------------------------------------------------------------
    */
    if ($user->hasRole('direction_cultes')) {

        return redirect()->route('admin.services.calendar');
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSABLES D'ÉQUIPES
    |--------------------------------------------------------------------------
    */

    if (
        $user->hasAnyRole([
            'responsable_afebeci',
            'responsable_jaebeci',
            'equipe_priere',
            'equipe_evangelisation'
        ])
    ) {

        if (!$user->team_id) {
            abort(403, 'Aucune équipe assignée.');
        }

        return redirect()->route(
            'admin.teams.show',
            $user->team_id
        );
    }

    abort(403);

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'force.password.change',
    'ensure.user.active',
    'auto.logout'
])
->prefix('admin')
->name('admin.')
->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        App\Http\Controllers\Admin\DashboardController::class,
        'index'
    ])->name('menu.dashboard');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN ROUTES
    | Pasteur + Secretariat
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        'role:pasteur,secretariat'
    ])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        Route::get('statistics', [
            App\Http\Controllers\Admin\StatisquesController::class,
            'index'
        ])->name('believers.statistics');


        /*
        |--------------------------------------------------------------------------
        | BELIEVERS
        |--------------------------------------------------------------------------
        */

        Route::get('believers/search', [
            App\Http\Controllers\Admin\BelieverController::class,
            'search'
        ])->name('believers.search');

        Route::get('believers/sanctions', [
            App\Http\Controllers\Admin\BelieverController::class,
            'disciplinarySanction'
        ])->name('believers.sanctions');

        Route::get('believers/departures', [
            App\Http\Controllers\Admin\BelieverController::class,
            'departures'
        ])->name('believers.departures');

        Route::resource('believers',
            App\Http\Controllers\Admin\BelieverController::class
        );

        Route::get('believers/{believer}/generate-pdf', [
            App\Http\Controllers\Admin\BelieverController::class,
            'generatePdf'
        ])->name('believers.generate_pdf');

        Route::get('believers/export/excel', [
            App\Http\Controllers\Admin\BelieverController::class,
            'exportExcel'
        ])->name('believers.export_excel');

        Route::post('believers/import/excel', [
            App\Http\Controllers\Admin\BelieverController::class,
            'importExcel'
        ])->name('believers.import_excel');

        Route::get('believers/import/template', [
            App\Http\Controllers\Admin\BelieverController::class,
            'downloadImportTemplate'
        ])->name('believers.download_import_template');

        Route::post('believers/{believer}/discipline', [
            App\Http\Controllers\Admin\BelieverController::class,
            'applyDiscipline'
        ])->name('believers.applyDiscipline');

        Route::patch('believers/{believer}/discipline/lift-discipline', [
            App\Http\Controllers\Admin\BelieverController::class,
            'liftDiscipline'
        ])->name('believers.liftDiscipline');

        Route::post('believers/{believer}/leave', [
            App\Http\Controllers\Admin\BelieverController::class,
            'leave'
        ])->name('believers.leave');

        Route::patch('believers/{believer}/reintegrate', [
            App\Http\Controllers\Admin\BelieverController::class,
            'reintegrate'
        ])->name('believers.reintegrate');


        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::resource('users',
            App\Http\Controllers\Admin\UserController::class
        )->except(['show']);

        Route::post('users/{user}/deactivate', [
            App\Http\Controllers\Admin\UserController::class,
            'deactivate'
        ])->name('users.deactivate');

        Route::patch('users/{user}/reactivate', [
            App\Http\Controllers\Admin\UserController::class,
            'reactivate'
        ])->name('users.reactivate');


        /*
        |--------------------------------------------------------------------------
        | LOGIN HISTORIES
        |--------------------------------------------------------------------------
        */

        Route::get('login-histories', [
            App\Http\Controllers\Admin\LoginHistoryController::class,
            'index'
        ])->name('login.histories');


        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        Route::resource('roles',
            App\Http\Controllers\Admin\RoleController::class
        )->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | CHURCH INFO
        |--------------------------------------------------------------------------
        */

        Route::resource('church_info',
            App\Http\Controllers\Admin\ChurchInfoController::class
        );


        /*
        |--------------------------------------------------------------------------
        | PROGRAMS
        |--------------------------------------------------------------------------
        */

        Route::resource('programs',
            App\Http\Controllers\Admin\ProgramController::class
        );


        /*
        |--------------------------------------------------------------------------
        | PERIODES
        |--------------------------------------------------------------------------
        */

        Route::resource('periodes',
            App\Http\Controllers\Admin\PeriodeController::class
        );

        Route::patch('periodes/{periode}/activate', [
            App\Http\Controllers\Admin\PeriodeController::class,
            'activate'
        ])->name('periodes.activate');


        /*
        |--------------------------------------------------------------------------
        | FUNERALS
        |--------------------------------------------------------------------------
        */

        Route::resource('funerals',
            App\Http\Controllers\Admin\FuneralRegisterController::class
        );

        Route::get('funerals/{funeral}/generate-pdf', [
            App\Http\Controllers\Admin\FuneralRegisterController::class,
            'generatePdf'
        ])->name('funerals.pdf');


        /*
        |--------------------------------------------------------------------------
        | CHILD DEDICATIONS
        |--------------------------------------------------------------------------
        */

        Route::resource('child_dedications',
            App\Http\Controllers\Admin\ChildDedicationController::class
        );

        Route::get('child_dedications/{child_dedication}/generate-pdf', [
            App\Http\Controllers\Admin\ChildDedicationController::class,
            'generatePdf'
        ])->name('child_dedications.generate_pdf');


        /*
        |--------------------------------------------------------------------------
        | MARIAGES
        |--------------------------------------------------------------------------
        */

        Route::resource('mariages',
            App\Http\Controllers\Admin\MariageRegisterController::class
        );

        Route::get('mariages/{mariage}/generate-pdf', [
            App\Http\Controllers\Admin\MariageRegisterController::class,
            'generatePdf'
        ])->name('mariages.generate_pdf');


        /*
        |--------------------------------------------------------------------------
        | GROUPS
        |--------------------------------------------------------------------------
        */

        Route::resource('groups',
            App\Http\Controllers\Admin\GroupController::class
        );

    });


    /*
    |--------------------------------------------------------------------------
    | SERVICES / CULTES
    | Pasteur + Secretariat + Direction des cultes
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        'role:pasteur,secretariat,direction_cultes'
    ])->group(function () {

        Route::resource('services',
            App\Http\Controllers\Admin\ServiceController::class
        )->except(['show']);

        Route::get('/services/calendar', [
            App\Http\Controllers\Admin\ServiceController::class,
            'calendar'
        ])->name('services.calendar');

        Route::post('/services/{service}/update-date', [
            App\Http\Controllers\Admin\ServiceController::class,
            'updateDate'
        ])->name('services.updateDate');

        Route::get('/services/pdf', [
            App\Http\Controllers\Admin\ServiceController::class,
            'exportPdf'
        ])->name('services.pdf');

    });


    /*
    |--------------------------------------------------------------------------
    | TEAMS
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        'role:pasteur,secretariat,responsable_afebeci,responsable_jaebeci,equipe_priere,equipe_evangelisation'
    ])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | TEAMS
        |--------------------------------------------------------------------------
        */

        Route::resource('teams',
            App\Http\Controllers\Admin\TeamController::class
        );


        /*
        |--------------------------------------------------------------------------
        | TEAM MEMBERS
        |--------------------------------------------------------------------------
        */

        Route::post('teams/{team}/assign-believer', [
            App\Http\Controllers\Admin\TeamController::class,
            'assignBeliever'
        ])->name('teams.assignBeliever');

        Route::delete('teams/{team}/remove-believer/{believer}', [
            App\Http\Controllers\Admin\TeamController::class,
            'removeBeliever'
        ])->name('teams.removeBeliever');


        /*
        |--------------------------------------------------------------------------
        | EXPORTS
        |--------------------------------------------------------------------------
        */

        Route::get('/teams/{team}/export-excel', [
            App\Http\Controllers\Admin\TeamController::class,
            'exportExcel'
        ])->name('teams.exportExcel');

        Route::get('/teams/{team}/export-pdf', [
            App\Http\Controllers\Admin\TeamController::class,
            'exportPdf'
        ])->name('teams.exportPdf');


        /*
        |--------------------------------------------------------------------------
        | ACTIVITIES
        |--------------------------------------------------------------------------
        */

        Route::get('/teams/{team}/activities', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'index'
        ])->name('teams.activities.index');

        Route::get('/teams/{team}/activities/create', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'create'
        ])->name('teams.activities.create');

        Route::post('/teams/{team}/activities', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'store'
        ])->name('teams.activities.store');

        Route::get('/teams/{team}/activities/{activity}', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'show'
        ])->name('teams.activities.show');

        Route::get('/teams/{team}/activities/{activity}/edit', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'edit'
        ])->name('teams.activities.edit');

        Route::put('/teams/{team}/activities/{activity}', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'update'
        ])->name('teams.activities.update');

        Route::delete('/teams/{team}/activities/{activity}', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'destroy'
        ])->name('teams.activities.destroy');


        /*
        |--------------------------------------------------------------------------
        | OBJECTIVES
        |--------------------------------------------------------------------------
        */

        Route::resource('teams.objectives',
            App\Http\Controllers\Admin\TeamObjectiveController::class
        )->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | EXPENSES
        |--------------------------------------------------------------------------
        */

        Route::prefix('teams/{team}/activities/{activity}')
            ->name('teams.activities.')
            ->group(function () {

                Route::post('/expenses', [
                    App\Http\Controllers\Admin\TeamActivityExpenseController::class,
                    'store'
                ])->name('expenses.store');

                Route::put('/expenses/{expense}', [
                    App\Http\Controllers\Admin\TeamActivityExpenseController::class,
                    'update'
                ])->name('expenses.update');

                Route::delete('/expenses/{expense}', [
                    App\Http\Controllers\Admin\TeamActivityExpenseController::class,
                    'destroy'
                ])->name('expenses.destroy');

            });


        /*
        |--------------------------------------------------------------------------
        | DOCUMENTS
        |--------------------------------------------------------------------------
        */

        Route::post('/teams/{team}/activities/{activityProgram}/documents', [
            App\Http\Controllers\Admin\TeamActivityDocumentController::class,
            'store'
        ])->name('teams.activities.documents.store');

        Route::delete('/teams/{team}/activities/{activityProgram}/documents/{document}', [
            App\Http\Controllers\Admin\TeamActivityDocumentController::class,
            'destroy'
        ])->name('teams.activities.documents.destroy');


        /*
        |--------------------------------------------------------------------------
        | ANNUAL REPORT
        |--------------------------------------------------------------------------
        */

        Route::get('/teams/{team}/activities/report', [
            App\Http\Controllers\Admin\ActivityProgramController::class,
            'annualReport'
        ])->name('teams.activities.annualReport');

    });

});