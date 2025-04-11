<?php


namespace App\Http\Livewire\RolesAndPermissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionComponent extends Component
{
    use WithPagination;

    public $name;
    public $permissionIdBeingUpdated;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|unique:permissions,name',
    ];

    public function render()
    {
        $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->paginate(10);

        return view('livewire.roles-and-permissions.permission-component', [
            'permissions' => $permissions
        ]);
    }

    public function resetInput()
    {
        $this->name = '';
        $this->permissionIdBeingUpdated = null;
        $this->isEditing = false;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Permission::create([
            'name' => $this->name,
        ]);

        session()->flash('status', 'Permission Created Successfully');
        $this->resetInput();
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionIdBeingUpdated = $id;
        $this->name = $permission->name;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|unique:permissions,name,' . $this->permissionIdBeingUpdated
        ]);

        $permission = Permission::findOrFail($this->permissionIdBeingUpdated);
        $permission->update([
            'name' => $this->name
        ]);

        session()->flash('status', 'Permission Updated Successfully');
        $this->resetInput();
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        session()->flash('status', 'Permission Deleted Successfully');
    }
}
