<?php

namespace App\Http\Livewire\RolesAndPermissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleComponent extends Component
{
    use WithPagination;

    public $name;
    public $roleIdBeingUpdated;
    public $isEditing = false;
    public $search = '';
    public $allPermissions = [];
    public $selectedPermissions = [];

    public $isAssigningPermissions = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:roles,name' . ($this->roleIdBeingUpdated ? ',' . $this->roleIdBeingUpdated : ''),
        ];
    }

    public function mount()
    {
        $this->allPermissions = Permission::all();
    }

    public function render()
    {
        $roles = $this->search!= ""?Role::where('name', 'like', '%' . $this->search . '%')->paginate(10):Role::paginate(10);
        return view('livewire.roles-and-permissions.role-component', [
            'roles' => $roles
        ]);
    }

    public function resetInput()
    {
        $this->name = '';
        $this->roleIdBeingUpdated = null;
        $this->isEditing = false;
        $this->isAssigningPermissions = false;
        $this->selectedPermissions = [];
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Role::create([
            'name' => $this->name,
        ]);

        session()->flash('status', 'Role Created Successfully');
        $this->resetInput();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->roleIdBeingUpdated = $id;
        $this->name = $role->name;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name,' . $this->roleIdBeingUpdated
        ]);

        $role = Role::findOrFail($this->roleIdBeingUpdated);
        $role->update([
            'name' => $this->name,
        ]);

        session()->flash('status', 'Role Updated Successfully');
        $this->resetInput();
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        session()->flash('status', 'Role Deleted Successfully');
    }

    public function assignPermissions($id)
    {
        $role = Role::findOrFail($id);
        $this->roleIdBeingUpdated = $id;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->isAssigningPermissions = true;
    }

    public function saveAssignedPermissions()
    {
        $role = Role::findOrFail($this->roleIdBeingUpdated);
        $role->syncPermissions($this->selectedPermissions);

        session()->flash('status', 'Permissions assigned successfully.');
        $this->resetInput();
    }
}
