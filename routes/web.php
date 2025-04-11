<?php

use App\Models\Live\CallSession;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Agent\AgentShow;
use App\Http\Livewire\Live\Recordings;
use App\Http\Livewire\Configs\Contexts;
use App\Http\Livewire\Live\ManageAgents;
use App\Http\Livewire\Reports\SearchCDR;
use App\Http\Livewire\Configs\Destination;
use App\Http\Livewire\Live\RecordingsShow;
use App\Http\Livewire\Configs\ShowContexts;
use App\Http\Livewire\Live\TransactionCode;
use App\Http\Livewire\Reports\DashboardIndex;
use App\Http\Controllers\Live\AudioController;
use App\Http\Livewire\Session\ShowCallSession;
use App\Http\Livewire\Live\DashboardController;
use App\Http\Livewire\User\Suspend\SuspendForm;
use App\Http\Livewire\Reports\CallDetailRecords;
use App\Http\Livewire\User\Suspend\SuspendIndex;
use App\Http\Livewire\Reports\CallSummaryRecords;
use App\Http\Livewire\User\Suspend\UnSuspendForm;
use App\Http\Livewire\User\UserOverview\ShowUser;
use App\Http\Livewire\User\Suspend\SuspendAllForm;
use App\Http\Livewire\Configurations\PbxCredentials;
use App\Http\Livewire\User\Suspend\UnSuspendAllForm;
use App\Http\Livewire\User\UserOverview\UserProfile;
use App\Http\Livewire\Session\CallSessionsController;
use App\Http\Livewire\User\UserOverview\ListAllUsers;
use App\Http\Livewire\User\UserOverview\CreateNewUser;
use App\Http\Livewire\Live\Supervisor\SupervisorDashboard;
use App\Http\Livewire\Live\Agent\DashboardController as AgentDashboardController;
use App\Http\Livewire\RolesAndPermissions\PermissionComponent;
use App\Http\Livewire\RolesAndPermissions\RoleComponent;
use App\Http\Livewire\RolesAndPermissions\UserComponent;
use App\Http\Livewire\RolesAndPermissions\UserEditComponent;
use App\Http\Livewire\RolesAndPermissions\UserManagement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/audio/{file?}/{extension?}', [AudioController::class, 'embedAudio'])->name('embedaudio');

Auth::routes();

Route::middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/', DashboardIndex::class)->name('reports.index');
    Route::get('/reports/index', DashboardIndex::class)->name('reports.index');
    Route::get('/users/profile', UserProfile::class)->name('user.profile');
    Route::get('/users/show/{id}', ShowUser::class)->name('user.show');
    Route::get('/users/create-user', CreateNewUser::class)->name('user.create');
    Route::get('/users/list-all', ListAllUsers::class)->name('user.list');
    Route::get('/users/block/index', SuspendIndex::class)->name('suspend.index');
    Route::get('/users/suspend/all/create', SuspendAllForm::class)->name('suspend.all.create');
    Route::get('/users/suspend/{user}/create', SuspendForm::class)->name('suspend.one.create');
    Route::get('/users/un-suspend/all/create', UnSuspendAllForm::class)->name('un-suspend.all.create');
    Route::get('/users/un-suspend/{user}/create', UnSuspendForm::class)->name('un-suspend.one.create');

    // Configuration Routes
    Route::get('config/destinations', Destination::class)->name('config.destinations');
    Route::get('config/contexts', Contexts::class)->name('config.contexts');
    Route::get('config/show/contexts/{id}', ShowContexts::class)->name('config.show.contexts');

    Route::get('reports/call/summary/records', CallSummaryRecords::class)->name('reports.call.summary.records');
    Route::get('reports/show/contexts/{id}', ShowContexts::class)->name('reports.show.contexts');
    Route::get('/reports/call/detail/records', CallDetailRecords::class)->name('reports.call.detail.records');
    Route::get('reports/show/cdr/{id}', CallDetailRecords::class)->name('reports.show.cdr');
    Route::get('reports/search', SearchCDR::class)->name('reports.search');

    Route::get('live/dashboard', DashboardController::class)->name('live.dashboard');
    Route::get('live/recordings/show/{id}', RecordingsShow::class)->name('live.recordings.show');
    Route::get('live/recordings', Recordings::class)->name('live.recordings');

    Route::get('live/agent/dashboard/{id}', AgentDashboardController::class)->name('live.agent.dashboard');


    Route::get('live/agent/manage', ManageAgents::class)->name('live.agent.manage');
    Route::get('live/agent/show/{id}', AgentShow::class)->name('live.agent.show');

    //Route::get('live/agent/showagentnumber/{id}', AgentShow::class)->name('live.agent.show.agentnumber');


    Route::get('live/supervisor/dashboard', SupervisorDashboard::class)->name('live.supervisor.dashboard');

    Route::get('configurations/pbx-credentials', PbxCredentials::class)->name('configurations.pbx-credentials');
    Route::get('session/call-sessions', CallSessionsController::class)->name('session.call-sessions');
    Route::get('session/call-sessions/show/{id}', ShowCallSession::class)->name('session.call-sessions.show');



    Route::get('live/transactionCodes', TransactionCode::class)->name('live.transactionCodes');
});

Route::middleware(['auth', 'role:agent|super-admin|admin'])->group(function () {
    // Route::get('live/agent/dashboard', AgentDashboardController::class)->name('live.agent.dashboard');
});

// Route::middleware(['auth', 'role:agent|super-admin|pbx-admin'])->group(function () {
//     Route::get('configurations/pbx-credentials', PbxCredentials::class)->name('configurations.pbx-credentials');
// });

Route::group(['middleware' => ['role:super-admin|admin']], function () {
    // Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions', PermissionComponent::class)->name('permissions.index');
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    // Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles', RoleComponent::class)->name('roles.index');
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole'])->name('role.roledid.give-permissions');
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);


    Route::get('users', UserComponent::class)->name('users.index');

    Route::get('users/{userId}/edit', UserEditComponent::class)->name('users.edit');
    // Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
});


Route::get('/phone', function () {
    return view('phone');
});
