<?php

namespace App\Http\Livewire\RolesAndPermissions;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection; // Import Collection

class UserEditComponent extends Component
{
    public $userId;
    public $user;
    public $userIdBeingEdited;
    public $isEditing = false;
    public $name, $email, $man_no, $password;
    public $roles = []; // This will hold the selected roles from the form

    // A property to hold the user's roles when the component was mounted
    protected $currentAssignedRoles;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userIdBeingEdited,
            'password' => 'nullable|min:6',
            'roles' => 'array', // Allow it to be an empty array
            'roles.*' => 'string|exists:roles,name', // Validate each role name
        ];
    }

    public function mount($userId)
    {
        $this->userId = $userId;

        $this->user = User::findOrFail($userId);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->man_no = $this->user->man_no;

        // Initialize the 'roles' property with the user's current roles
        $this->roles = $this->user->roles->pluck('name')->toArray();
        // Store the current roles separately to compare during update
        $this->currentAssignedRoles = $this->user->roles->pluck('name'); // Store as Collection for easy diff

        $this->userIdBeingEdited = $this->user->id;
        $this->isEditing = true;
    }

    public function render()
    {
        return view('livewire.role-permission.user.edit', [
            'user' => $this->user,
            'userRoles' => $this->roles, // This is already available via $this->roles directly
            'allRoles' => Role::pluck('name')->toArray(), // Pass all available roles
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

        // --- Role Management Logic (Modified) ---
        $newlySelectedRoles = collect($this->roles); // Roles submitted from the form
        // Re-fetch current roles from the user to ensure it's up-to-date
        $currentlyAssignedRoles = $user->roles->pluck('name');

        // Determine roles to assign
        $rolesToAssign = $newlySelectedRoles->diff($currentlyAssignedRoles);

        // Determine roles to remove
        $rolesToRemove = $currentlyAssignedRoles->diff($newlySelectedRoles);

        foreach ($rolesToAssign as $roleName) {
            $user->assignRole($roleName);
        }

        foreach ($rolesToRemove as $roleName) {
            $user->removeRole($roleName);
        }
        // --- End Role Management Logic ---

        session()->flash('status', 'User updated successfully with roles.');
        // After successful update, you might want to refresh the roles property
        // to reflect the new state, especially if the user remains on the same page
        $this->roles = $user->roles->pluck('name')->toArray();
        $this->currentAssignedRoles = $user->roles->pluck('name'); // Update this too

        // Optionally, redirect after update
        // return redirect()->route('users.index'); // or wherever your user list is
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->roles = [];
        $this->isEditing = false;
        // If you reset, you might lose the context of the user being edited.
        // This method is typically used for 'create' forms after submission.
        // For 'edit' forms, you usually redirect or re-mount the component.
    }
}