<?php

namespace App\Http\Livewire\User\Suspend;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithPagination;

class SuspendIndex extends Component
{
    use WithPagination;

    public $searchTerm;
    public $isBlocked;
    public $fromDate;
    public $toDate;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'searchTerm' => ['except' => '']
    ];

    public function mount()
    {
        $this->searchTerm = '';
        $this->toDate = null;
        $this->fromDate = null;
        $this->isBlocked = 0;
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {

        $dataset = User::query();

        $dataset->orderBy('firstname')
            ->orderBy('lastname');


        if ($this->isBlocked) {
            $dataset = $dataset->where('id', '!=', Auth::user()->id)->whereNotNull('banned_until');
        } else {
            $dataset = $dataset->where('id', '!=', Auth::user()->id)->whereNull('banned_until');
        }

//        if ($this->searchTerm && strlen($this->searchTerm) >= 5) {
        if ($this->searchTerm) {
            $dataset->where(function ($query) {
                $query
                    ->orWhere(DB::raw('lower(name)'),'like', '%' . strtolower($this->searchTerm) . '%')
                    ->orWhere('man_no', 'LIKE', $this->searchTerm . '%');
            });

            $dataset = $dataset->paginate(10);
        } else {
//            $dataset = [];
            $dataset = $dataset->paginate(10);
        }

        return view('livewire.user.suspend.suspend-index',compact('dataset'));
    }


    public function unSuspendAll()
    {
        User::where('id', '!=', Auth::user()->id)
            ->whereNotNull('banned_until')
            ->update(['banned_until' => null]);

        return Redirect::route('suspend.index')
            ->with('message', 'Un-Suspended successfully');
    }
}
