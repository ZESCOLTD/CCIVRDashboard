<?php
//
//use App\Models\Live\CallSession;
//use Illuminate\Support\Facades\Route;
//use App\Http\Livewire\Agent\AgentShow;
//use App\Http\Livewire\Live\Recordings;
//use App\Http\Livewire\Configs\Contexts;
//use App\Http\Livewire\Live\ManageAgents;
//use App\Http\Livewire\Reports\SearchCDR;
//use App\Http\Livewire\Configs\Destination;
//use App\Http\Livewire\Live\RecordingsShow;
//use App\Http\Livewire\Configs\ShowContexts;
//use App\Http\Livewire\Live\TransactionCode;
//use App\Http\Livewire\Reports\DashboardIndex;
//use App\Http\Controllers\Live\AudioController;
//use App\Http\Livewire\Session\ShowCallSession;
//use App\Http\Livewire\Live\DashboardController;
//use App\Http\Livewire\User\Suspend\SuspendForm;
//use App\Http\Livewire\Reports\CallDetailRecords;
//use App\Http\Livewire\User\Suspend\SuspendIndex;
//use App\Http\Livewire\Reports\CallSummaryRecords;
//use App\Http\Livewire\User\Suspend\UnSuspendForm;
//use App\Http\Livewire\User\UserOverview\ShowUser;
//use App\Http\Livewire\User\Suspend\SuspendAllForm;
//use App\Http\Livewire\Configurations\PbxCredentials;
//use App\Http\Livewire\User\Suspend\UnSuspendAllForm;
//use App\Http\Livewire\User\UserOverview\UserProfile;
//use App\Http\Livewire\Session\CallSessionsController;
//use App\Http\Livewire\User\UserOverview\ListAllUsers;
//use App\Http\Livewire\User\UserOverview\CreateNewUser;
//use App\Http\Livewire\Live\Supervisor\SupervisorDashboard;
//use App\Http\Livewire\Live\Agent\DashboardController as AgentDashboardController;
//use App\Http\Livewire\RolesAndPermissions\PermissionComponent;
//use App\Http\Livewire\RolesAndPermissions\RoleComponent;
//use App\Http\Livewire\RolesAndPermissions\UserComponent;
//use App\Http\Livewire\RolesAndPermissions\UserEditComponent;
////use App\Http\Livewire\Live\Supervisor\KnowledgeBaseManager;
//use App\Http\Livewire\RolesAndPermissions\UserManagement;
//use App\Http\Livewire\Report\ReportController;
//use App\Http\Livewire\ReportFilter;
//use App\Http\Livewire\ReportExport;
//use App\Http\Livewire\GeneralReport;
//use App\Http\Livewire\GeneralReportExport;
//
//use App\Models\User;
//use Illuminate\Support\Facades\Auth;
//use App\Http\Livewire\Live\Supervisor\KnowledgeBase\KnowledgeBaseManager;
//
///*
//|--------------------------------------------------------------------------
//| Web Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register web routes for your application. These
//| routes are loaded by the RouteServiceProvider within a group which
//| contains the "web" middleware group. Now create something great!
//|
//*/
//
//// Route::get('/', function () {
////     return view('auth.login');
//// });
//
//Route::get('/audio/{file?}/{extension?}', [AudioController::class, 'embedAudio'])->name('embedaudio');
//
//Auth::routes();
//
//Route::middleware(['auth', 'role:super-admin|admin|agent'])->group(function () {
//    Route::get('/', DashboardIndex::class)->name('reports.index');
//    Route::get('/reports/index', DashboardIndex::class)->name('reports.index');
//    Route::get('/users/profile', UserProfile::class)->name('user.profile');
//    Route::get('/users/show/{id}', ShowUser::class)->name('user.show');
//    Route::get('/users/create-user', CreateNewUser::class)->name('user.create');
//    Route::get('/users/list-all', ListAllUsers::class)->name('user.list');
//    Route::get('/users/block/index', SuspendIndex::class)->name('suspend.index');
//    Route::get('/users/suspend/all/create', SuspendAllForm::class)->name('suspend.all.create');
//    Route::get('/users/suspend/{user}/create', SuspendForm::class)->name('suspend.one.create');
//    Route::get('/users/un-suspend/all/create', UnSuspendAllForm::class)->name('un-suspend.all.create');
//    Route::get('/users/un-suspend/{user}/create', UnSuspendForm::class)->name('un-suspend.one.create');
//
//    // Configuration Routes
//    Route::get('config/destinations', Destination::class)->name('config.destinations');
//    Route::get('config/contexts', Contexts::class)->name('config.contexts');
//    Route::get('config/show/contexts/{id}', ShowContexts::class)->name('config.show.contexts');
//
//    Route::get('reports/call/summary/records', CallSummaryRecords::class)->name('reports.call.summary.records');
//    Route::get('reports/show/contexts/{id}', ShowContexts::class)->name('reports.show.contexts');
//    Route::get('/reports/call/detail/records', CallDetailRecords::class)->name('reports.call.detail.records');
//    Route::get('reports/show/cdr/{id}', CallDetailRecords::class)->name('reports.show.cdr');
//    Route::get('reports/search', SearchCDR::class)->name('reports.search');
//
//    Route::get('live/dashboard', DashboardController::class)->name('live.dashboard');
//    Route::get('live/recordings/show/{id}', RecordingsShow::class)->name('live.recordings.show');
//    Route::get('live/recordings', Recordings::class)->name('live.recordings');
//
//    Route::get('live/agent/dashboard/{id}', AgentDashboardController::class)->name('live.agent.dashboard');
//
//
//    Route::get('live/agent/manage', ManageAgents::class)->name('live.agent.manage');
//    Route::get('live/agent/show/{id}', AgentShow::class)->name('live.agent.show');
//
//    //Route::get('live/agent/showagentnumber/{id}', AgentShow::class)->name('live.agent.show.agentnumber');
//
//
//    Route::get('live/supervisor/dashboard', SupervisorDashboard::class)->name('live.supervisor.dashboard');
//
//    Route::get('configurations/pbx-credentials', PbxCredentials::class)->name('configurations.pbx-credentials');
//    Route::get('session/call-sessions', CallSessionsController::class)->name('session.call-sessions');
//    Route::get('session/call-sessions/show/{id}', ShowCallSession::class)->name('session.call-sessions.show');
//
//
//
//    Route::get('live/transactionCodes', TransactionCode::class)->name('live.transactionCodes');
//});
//
//Route::middleware(['auth', 'role:agent|super-admin|admin'])->group(function () {
//    // Route::get('live/agent/dashboard', AgentDashboardController::class)->name('live.agent.dashboard');
//});
//
//// Route::middleware(['auth', 'role:agent|super-admin|pbx-admin'])->group(function () {
////     Route::get('configurations/pbx-credentials', PbxCredentials::class)->name('configurations.pbx-credentials');
//// });
//
//Route::group(['middleware' => ['role:super-admin|admin']], function () {
//    // Route::resource('permissions', App\Http\Controllers\PermissionController::class);
//    Route::get('permissions', PermissionComponent::class)->name('permissions.index');
//    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);
//
//    // Route::resource('roles', App\Http\Controllers\RoleController::class);
//    Route::get('roles', RoleComponent::class)->name('roles.index');
//    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
//    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole'])->name('role.roledid.give-permissions');
//    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
//
//
//    Route::get('users', UserComponent::class)->name('users.index');
//
//    Route::get('users/{userId}/edit', UserEditComponent::class)->name('users.edit');
//    // Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
//});
//
//
//Route::get('/phone', function () {
//    return view('phone');
//});
//
//Route::get('/user/status', function() {
//    return response()->json([
//        'online' => Auth::check() ? Auth::user()->isOnline() : false,
//        'is_banned' => Auth::check() ? Auth::user()->is_banned : false
//    ]);
//})->middleware('auth:sanctum')->name('api.user.status');
//
//// routes/web.php
//
//
//Route::get('/knowledge-base', function () {
//    return view('layouts.app', [
//        'component' => new KnowledgeBaseManager()
//    ]);
//})->name('live.supervisor.knowledge-base');
//
//
//Route::middleware('auth:api')->group(function() {
//    // Agent and queue data
//    Route::get('/agents', [GeneralReportController::class, 'getAgents']);
//    Route::get('/queues', [GeneralReportController::class, 'getQueues']);
//
//    // Report endpoints
//    Route::post('/reports/generate', [GeneralReportController::class, 'generateReport']);
//    Route::post('/reports/email', [GeneralReportController::class, 'emailReport']);
//    Route::post('/reports/automated', [GeneralReportController::class, 'configureAutomatedReports']);
//});
//
//// Routes for report filtering and exporting
//Route::get('/report/configure/automated', [ReportController::class, 'configure-automated'])->name('reports.configure-automated');
//Route::get('/report/email', [ReportController::class, 'email'])->name('reports.email');
//Route::get('/report/filter', [ReportController::class, 'filter'])->name('report.filter');
//Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');
//Route::get('/general/report', [ReportController::class, 'generalReport'])->name('general.report');
//Route::get('/general/report/export', [ReportController::class, 'generalReportExport'])->name('general.report.export');
//Route::get('/general-report', GeneralReport::class)->name('general-report');
//
//// Knowledge Base Management
//Route::get('/technical', \App\Http\Livewire\Technical\TechnicalControllers::class)->name('technical.index');
//
//


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
use App\Http\Controllers\Report\GeneralReportController;
use App\Http\Livewire\Report\ReportController;
use App\Http\Livewire\GeneralReport;
use App\Http\Livewire\Live\Agent\OutboundComponent;
// use App\Http\Livewire\Live\DialEventsComponent;
use App\Http\Livewire\Live\StasisEndEventComponent;
use App\Http\Livewire\Live\StasisStartEventComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Live\Supervisor\KnowledgeBase\KnowledgeBaseManager;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/audio/{file?}/{extension?}', [AudioController::class, 'embedAudio'])->name('embedaudio');

Auth::routes();

// Main Application Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard and Reports
    // Route::middleware(['auth', 'check.weak.password'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // });
    Route::get('/change-password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/change-password', [PasswordController::class, 'update']);

    Route::get('/getManNumbersFiltered', [Controller::class, 'getManNumbers'])->name('getManNumbersFiltered');


    // Route::middleware(['role:super-admin|admin'])->group(function () {
        // Password Management
        Route::get('/', DashboardIndex::class)->name('reports.index');
        Route::get('/reports/index', DashboardIndex::class)->name('reports.index');
        Route::get('/reports/call/summary/records', CallSummaryRecords::class)->name('reports.call.summary.records');
        Route::get('/reports/call/detail/records', CallDetailRecords::class)->name('reports.call.detail.records');
        Route::get('/reports/show/cdr/{id}', CallDetailRecords::class)->name('reports.show.cdr');
        Route::get('/reports/search', SearchCDR::class)->name('reports.search');
    // });



    // Route::middleware(['role:super-admin|admin'])->group(function () {
        // User Management
        Route::get('/users/profile', UserProfile::class)->name('user.profile');
        Route::get('/users/show/{id}', ShowUser::class)->name('user.show');
        Route::get('/users/create-user', CreateNewUser::class)->name('user.create');
        Route::get('/users/list-all', ListAllUsers::class)->name('user.list');
        Route::get('/users/block/index', SuspendIndex::class)->name('suspend.index');
        Route::get('/users/suspend/all/create', SuspendAllForm::class)->name('suspend.all.create');
        Route::get('/users/suspend/{user}/create', SuspendForm::class)->name('suspend.one.create');
        Route::get('/users/un-suspend/all/create', UnSuspendAllForm::class)->name('un-suspend.all.create');
        Route::get('/users/un-suspend/{user}/create', UnSuspendForm::class)->name('un-suspend.one.create');
    // });

    // Route::middleware(['role:super-admin|admin'])->group(function () {
        // Configuration
        Route::get('/config/destinations', Destination::class)->name('config.destinations');
        Route::get('/config/contexts', Contexts::class)->name('config.contexts');
        Route::get('/config/show/contexts/{id}', ShowContexts::class)->name('config.show.contexts');
        Route::get('/configurations/pbx-credentials', PbxCredentials::class)->name('configurations.pbx-credentials');
    // });

    // Live Components
    // Route::get('/live/dashboard', DashboardController::class)->name('live.dashboard');

    Route::get('/omnidashboard', \App\Http\Livewire\Pages\DashboardPage::class)->name('omnidashboard');

    Route::get('/live/agent/dashboard/{id}', AgentDashboardController::class)->name('live.agent.dashboard');

    Route::get('/live/agent/outbound/{id}', OutboundComponent::class)->name('live.agent.outbound');





    Route::middleware(['role:super-admin|admin|qa-officer|qa-supervisor'])->group(function () {

        Route::get('/live/recordings/show/{id}', RecordingsShow::class)->name('live.recordings.show');
        Route::get('/live/recordings', Recordings::class)->name('live.recordings');
        Route::get('/live/agent/manage', ManageAgents::class)->name('live.agent.manage');
        Route::get('/live/agent/show/{id}', AgentShow::class)->name('live.agent.show');
        Route::get('/live/supervisor/dashboard', SupervisorDashboard::class)->name('live.supervisor.dashboard');
        Route::get('/live/transactionCodes', TransactionCode::class)->name('live.transactionCodes');

        // Sessions
        Route::get('/session/call-sessions', CallSessionsController::class)->name('session.call-sessions');
        Route::get('/session/call-sessions/show/{id}', ShowCallSession::class)->name('session.call-sessions.show');
    });

    Route::middleware(['role:super-admin|admin|qa-officer|qa-supervisor'])->group(function () {

        // Route::get('/live/recordings/show/{id}', RecordingsShow::class)->name('live.recordings.show');
        // Route::get('/live/recordings', Recordings::class)->name('live.recordings');
        Route::get('/live/agent/manage', ManageAgents::class)->name('live.agent.manage');
        Route::get('/live/agent/show/{id}', AgentShow::class)->name('live.agent.show');
        Route::get('/live/supervisor/dashboard', SupervisorDashboard::class)->name('live.supervisor.dashboard');
        Route::get('/live/transactionCodes', TransactionCode::class)->name('live.transactionCodes');

        // Sessions
        Route::get('/session/call-sessions', CallSessionsController::class)->name('session.call-sessions');
        Route::get('/session/call-sessions/show/{id}', ShowCallSession::class)->name('session.call-sessions.show');
    });


    // Report Routes (Added missing ones)
    Route::middleware(['role:super-admin|admin|qa-officer|qa-supervisor'])->group(function () {
        Route::post('/reports/generate', [GeneralReportController::class, 'generateReport'])->name('reports.generate');
        Route::post('/reports/export', [GeneralReportController::class, 'exportReport'])->name('reports.export');
        Route::post('/reports/email', [GeneralReportController::class, 'emailReport'])->name('reports.email');
        Route::post('/reports/configure-automated', [GeneralReportController::class, 'configureAutomatedReports'])->name('reports.configure-automated');
        Route::get('/general-report', GeneralReport::class)->name('general-report');
        Route::get('/download-pdf', [\App\Http\Controllers\ReportExportController::class, 'downloadPDF'])->name('download.pdf');
    });

    Route::get('live/stasis-end-stats', StasisEndEventComponent::class)->name('live.stasis-end-stats');
    Route::get('live/stasis-start-stats', StasisStartEventComponent::class)->name('live.stasis-start-stats');


});

// Admin-only Routes
Route::middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/permissions', PermissionComponent::class)->name('permissions.index');
    Route::get('/permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    Route::get('/roles', RoleComponent::class)->name('roles.index');
    //    Route::get('/roles/create', App\Http\Livewire\RolesAndPermissions\RoleComponent::class)->name('roles-component.create');
    Route::get('/roles/create', RoleComponent::class)->name('roles.create');
    Route::get('/roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('/roles/{roleId}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.roledid.edit');
    Route::get('/roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole'])->name('role.roledid.give-permissions');
    Route::put('/roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

    Route::get('/users', UserComponent::class)->name('users.index');
    Route::get('/users/{userId}/edit', UserEditComponent::class)->name('users.edit');
});

// API Routes
Route::middleware('auth:api')->group(function () {
    Route::get('/agents', [GeneralReportController::class, 'getAgents'])->name('api.agents');
    Route::get('/queues', [GeneralReportController::class, 'getQueues'])->name('api.queues');
});

// Miscellaneous Routes
Route::get('/phone', function () {
    return view('phone');
})->name('phone');

Route::get('/user/status', function () {
    return response()->json([
        'online' => Auth::check() ? Auth::user()->isOnline() : false,
        'is_banned' => Auth::check() ? Auth::user()->is_banned : false
    ]);
})->middleware('auth:sanctum')->name('api.user.status');

Route::get('/knowledge-base', function () {
    return view('layouts.app', [
        'component' => new KnowledgeBaseManager()
    ]);
})->name('live.supervisor.knowledge-base');

Route::get('/technical', \App\Http\Livewire\Technical\TechnicalControllers::class)->name('technical.index');

Route::get('/audio/convert-mp3', function (\Illuminate\Http\Request $request) {
    $file = $request->query('file');
    $mp3Path = storage_path("app/converted/" . pathinfo($file, PATHINFO_FILENAME) . ".mp3");

    if (!file_exists($mp3Path)) {
        abort(404, 'MP3 file not found.');
    }

    return response()->download($mp3Path);
})->name('audio.convert.mp3');
