<?php

namespace App\Http\Livewire\Configurations;

use Livewire\Component;
use App\Models\Configurations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class PbxCredentials extends Component
{
    public $pbxUsername;
    public $password;
    public $passwordConfirm;

    public $data; // Data to be displayed
    public $newName, $newEmail; // For creating new record
    public $editName, $editEmail, $recordId; // For editing record

    // Validation Rules
    protected $rules = [
        'pbxUsername' => 'required',
        'password' => 'required',
        'passwordConfirm' => 'required'
    ];

    public function mount()
    {
        $this->loadData(); // Load your initial data
    }

    public function render()
    {
        $data = Configurations::where('config_key_id', '!=', 'pbx_password')->get();
        return view('livewire.configurations.pbx-credentials', ['data' => $data]);
    }

    public function create()
    {
        $this->validate();

        try {
            $username = Configurations::updateOrCreate(
                [
                    'config_key_id' => "pbx_username"
                ],
                [
                    'config_value' => $this->pbxUsername,
                ]
            );

            $password = Configurations::updateOrCreate(
                [
                    'config_key_id' => "pbx_password"
                ],
                [
                    'config_value' => Crypt::encrypt($this->password)
                ]
            );
            $password = Configurations::where('config_key_id', '=', config('constants.configs.pbx_password'))->first();

            ///dd($password);

            // Set success message
            session()->flash('message', 'PBX credentials successfully updated.');
        } catch (\Exception $e) {
            // Set error message
            session()->flash('error', 'Failed to update PBX credentials: ' . $e->getMessage());
        }
    }



    public function loadData()
    {
        // Load data from your model
        $this->data = Configurations::where('config_key_id', '!=', 'pbx_password')->get()->toArray();
    }

    public function openCreateModal()
    {
        $this->reset(['newName', 'newEmail']);
        $this->dispatchBrowserEvent('show-create-modal'); // Trigger modal
    }

    public function openEditModal($id)
    {
        $record = Configurations::find($id); // Load record
        $this->recordId = $id;
        $this->editName = $record->config_key_id; // Adjust based on your model
        $this->editEmail = $record->config_value; // Adjust based on your model
        $this->dispatchBrowserEvent('show-edit-modal'); // Trigger modal
    }

    public function createRecord()
    {
        // Logic to create a new record
        Configurations::create([
            'config_key_id' => $this->newName,
            'config_value' => $this->newEmail,
        ]);

        $this->loadData(); // Refresh data
        $this->dispatchBrowserEvent('close-modal'); // Close modal
    }

    public function updateRecord()
    {
        // Logic to update the record
        $record = Configurations::find($this->recordId);
        $record->update([
            'config_key_id' => $this->editName,
            'config_value' => $this->editEmail,
        ]);

        $this->loadData(); // Refresh data
        $this->dispatchBrowserEvent('close-modal'); // Close modal
    }

    public function closeModal()
    {
        $this->reset(['newName', 'newEmail', 'editName', 'editEmail']);
    }
}

// use Livewire\Component;

// class YourComponent extends Component
// {
//     public $data; // Data to be displayed
//     public $newName, $newEmail; // For creating new record
//     public $editName, $editEmail, $recordId; // For editing record

//     public function mount()
//     {
//         $this->loadData(); // Load your initial data
//     }

//     public function loadData()
//     {
//         // Load data from your model
//         $this->data = Model::all()->toArray(); // Adjust this line
//     }

//     public function openCreateModal()
//     {
//         $this->reset(['newName', 'newEmail']);
//         $this->dispatchBrowserEvent('show-create-modal'); // Trigger modal
//     }

//     public function openEditModal($id)
//     {
//         $record = Model::find($id); // Load record
//         $this->recordId = $id;
//         $this->editName = $record->config_key_id; // Adjust based on your model
//         $this->editEmail = $record->config_value; // Adjust based on your model
//         $this->dispatchBrowserEvent('show-edit-modal'); // Trigger modal
//     }

//     public function createRecord()
//     {
//         // Logic to create a new record
//         Model::create([
//             'config_key_id' => $this->newName,
//             'config_value' => $this->newEmail,
//         ]);

//         $this->loadData(); // Refresh data
//         $this->dispatchBrowserEvent('close-modal'); // Close modal
//     }

//     public function updateRecord()
//     {
//         // Logic to update the record
//         $record = Model::find($this->recordId);
//         $record->update([
//             'config_key_id' => $this->editName,
//             'config_value' => $this->editEmail,
//         ]);

//         $this->loadData(); // Refresh data
//         $this->dispatchBrowserEvent('close-modal'); // Close modal
//     }

//     public function closeModal()
//     {
//         $this->reset(['newName', 'newEmail', 'editName', 'editEmail']);
//     }

//     public function render()
//     {
//         return view('livewire.your-component');
//     }
// }
