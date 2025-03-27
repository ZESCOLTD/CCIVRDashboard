<?php

namespace App\Http\Livewire\User\UserOverview;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListAllUsers extends Component
{
    protected $paginationTheme = 'bootstrap';

    use WithPagination;

    public function render()
    {
        $users = User::paginate(10);
        return view('livewire.user.user-overview.list-all-users', ['users' => $users]);
    }
}
