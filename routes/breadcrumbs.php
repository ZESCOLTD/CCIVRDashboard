<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('reports.index', function ($trail) {
    $trail->push('Main Dashboard', route('reports.index'));
});

Breadcrumbs::for('reports.call.detail.records', function ($trail) {
    $trail->push('Call Detail Records', route('reports.call.detail.records'));
});


Breadcrumbs::for('suspend.index', function ($trail) {
    $trail->push('Suspend Users', route('suspend.index'));
});

Breadcrumbs::for('suspend.all', function ($trail) {
    $trail->push('Suspend Users', route('suspend.index'));
});


// Breadcrumbs::for('un-suspend.one', function ($trail, $user) {
//     $trail->push('Un-Suspend User', route('un-suspend.one', $user));
// });

Breadcrumbs::for('reports.call.summary.records', function ($trail) {
    $trail->push('Call Summary Reports', route('reports.call.summary.records'));
});

Breadcrumbs::for('reports.search', function ($trail) {
    $trail->push('Search Here', route('reports.search'));
});

Breadcrumbs::for('reports.show.cdr', function ($trail) {
    $trail->push('CDR Here', route('reports.show.cdr'));
});

Breadcrumbs::for('livewire.message', function ($trail) {
    $trail->push('Title Here', route('livewire.message'));
});


Breadcrumbs::for('un-suspend.one.create', function ($trail, $user) {
    $trail->push('Un-Suspend User', route('un-suspend.one.create', $user));
});

Breadcrumbs::for('user.profile', function ($trail) {
    $trail->push('User Profile', route('user.profile'));
});

Breadcrumbs::for('user.create', function ($trail) {
    $trail->push('Create New User', route('user.create'));
});

Breadcrumbs::for('config.destinations', function ($trail) {
    $trail->push('Config Destinations', route('config.destinations'));
});

Breadcrumbs::for('config.contexts', function ($trail) {
    $trail->push('Config contexts', route('config.contexts'));
});

Breadcrumbs::for('config.show.contexts', function ($trail, $id) {
    $trail->push('Context Details', route('config.show.contexts', $id));
});

Breadcrumbs::for('user.list', function ($trail) {
    $trail->push('Title Here', route('user.list'));
});

Breadcrumbs::for('user.show', function ($trail, $id) {
    $trail->push('Title Here', route('user.show', $id));
});

Breadcrumbs::for('live.dashboard', function ($trail) {
    $trail->push('RealTime Dashboard', route('live.dashboard'));
});

Breadcrumbs::for('live.recordings', function ($trail) {
    $trail->push('Call Center Recordings', route('live.recordings'));
});

Breadcrumbs::for('live.recordings.show', function ($trail, $id) {
    $trail->push('Selected Recording', route('live.recordings.show', $id));
});

Breadcrumbs::for('live.agent.dashboard', function ($trail, $id) {
    $trail->push('Agent dashboard', route('live.agent.dashboard', $id));
});

Breadcrumbs::for('live.agent.manage', function ($trail) {
    $trail->push('Manage Agents', route('live.agent.manage'));
});

Breadcrumbs::for('live.agent.show', function ($trail, $id) {
    $trail->push('Agent Details', route('live.agent.show', $id));
});

Breadcrumbs::for('live.supervisor.dashboard', function ($trail) {
    $trail->push('Supervisor DashBoard', route('live.supervisor.dashboard'));
});

Breadcrumbs::for('roles.index', function ($trail) {
    $trail->push('Roles Section', route('roles.index'));
});

Breadcrumbs::for('permissions.index', function ($trail) {
    $trail->push('Permissions section', route('permissions.index'));
});

Breadcrumbs::for('users.index', function ($trail) {
    $trail->push('Manage users', route('users.index'));
});

Breadcrumbs::for('users.edit', function ($trail, $id) {
    $trail->push('Edit user', route('users.edit', $id));
});

Breadcrumbs::for('roles.create', function ($trail) {
    $trail->push('Add role', route('roles.create'));
});

Breadcrumbs::for('role.roledid.give-permissions', function ($trail, $id) {
    $trail->push('Give role permissions', route('role.roledid.give-permissions', $id));
});

Breadcrumbs::for('roles.edit', function ($trail, $id) {
    $trail->push('Edit role', route('roles.edit', $id));
});

Breadcrumbs::for('permissions.create', function ($trail) {
    $trail->push('Add permission', route('permissions.create'));
});

Breadcrumbs::for('users.create', function ($trail) {
    $trail->push('Create user', route('users.create'));
});

Breadcrumbs::for('configurations.pbx-credentials', function ($trail) {
    $trail->push('PBX credentials', route('configurations.pbx-credentials'));
});

Breadcrumbs::for('session.call-sessions', function ($trail) {
    $trail->push('Call sessions', route('session.call-sessions'));
});

Breadcrumbs::for('session.call-sessions.show', function ($trail, $id) {
    $trail->push('Call session details', route('session.call-sessions.show', $id));
});

Breadcrumbs::for('live.transactionCodes', function ($trail) {
    $trail->push('Transaction codes', route('live.transactionCodes'));
});

Breadcrumbs::for('live.callstats', function ($trail) {
    $trail->push('Call Statistics', route('live.callstats'));
});

Breadcrumbs::for('live.stasis-end-stats', function ($trail) {
    $trail->push('Title Here', route('live.stasis-end-stats'));
});