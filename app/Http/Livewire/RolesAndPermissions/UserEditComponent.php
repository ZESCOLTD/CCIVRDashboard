<?php

namespace App\Http\Livewire\RolesAndPermissions;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserEditComponent extends Component
{
    public $userId;
    public $user;
    public $userIdBeingEdited;
    public $isEditing = false;
    public $name, $email, $man_no, $password, $roles = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userIdBeingEdited,
            'password' => 'nullable|min:6',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ];
    }

    public function mount($userId)
    {
        $this->userId = $userId;

        $this->user = User::findOrFail($userId);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->man_no=$this->user->man_no;
        $this->roles = $this->user->roles->pluck('name')->toArray();
        $this->userIdBeingEdited = $this->user->id;
        $this->isEditing = true;
    }
    public function render()
    {
        return view('livewire.role-permission.user.edit', [
            'user' => $this->user,
            'userRoles' => $this->roles,
            'allRoles' => Role::pluck('name')->toArray(),
        ]);
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

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->roles = [];
        $this->isEditing = false;
    }
}
