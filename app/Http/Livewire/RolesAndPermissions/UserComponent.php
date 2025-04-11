<?php

namespace App\Http\Livewire\RolesAndPermissions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserComponent extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $password;
    public $roles = [];
    public $userIdBeingEdited = null;
    public $isEditing = false;
    public $confirmingDelete = false;
    public $userIdToDelete;

    public $search;

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userIdBeingEdited,
            'password' => $this->isEditing ? 'nullable|string|min:8|max:20' : 'required|string|min:8|max:20',
            'roles' => 'required|array',
        ];
    }

    public function render()
    {

        $query = User::query();

        if ($this->search) {
            $search = strtolower($this->search);
            $query->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(man_no) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(firstname) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(middlename) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(lastname) like ?', ['%' . $search . '%']);
                    // ->orWhereHas('agent', function ($query) use ($search) {
                    //     $query->whereRaw('LOWER(name) like ?', ['%' . $search . '%']);
                    // });
            });
        }
        return view('livewire.roles-and-permissions.user-component', [
            'users' => $query->paginate(10),
            'allRoles' => Role::pluck('name', 'name')->all(),
        ]);
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->roles = [];
        $this->userIdBeingEdited = null;
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->syncRoles($this->roles);

        session()->flash('status', 'User created successfully with roles.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles->pluck('name')->toArray();
        $this->userIdBeingEdited = $user->id;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userIdBeingEdited);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);
        $user->syncRoles($this->roles);

        session()->flash('status', 'User updated successfully with roles.');
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->userIdToDelete = $id;
    }

    public function delete()
    {
        User::findOrFail($this->userIdToDelete)->delete();
        session()->flash('status', 'User deleted successfully.');
        $this->confirmingDelete = false;
    }

    public function updatedSearch()
    {
        $this->search = strtolower($this->search);
        // dd($this->search);
    }
}
