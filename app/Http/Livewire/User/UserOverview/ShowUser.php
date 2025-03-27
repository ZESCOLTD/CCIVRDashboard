<?php

namespace App\Http\Livewire\User\UserOverview;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ShowUser extends Component
{
    public $user;

    public $selectedEmployee;

    public $EmployeeGrade;

    public $name;

    public $Position;
    public $Division;
    public $password;
    public $StaffEmail;

    public $Department;
    public $StaffNumber;
    public $Directorate;

    public function mount($id)
    {
        $this->user = User::where('id', $id)->first();


        $this->StaffNumber = $this->user->man_no;


        $this->name = $this->user->name;
        $this->Position = $this->user->position;
        $this->Division = $this->user->division;
        $this->EmployeeGrade = $this->user->grade;

        $this->StaffEmail = $this->user->email;
        // 'status'=> 0,

        $this->Department = $this->user->location;
        $this->Directorate = $this->user->directorate;
        // $this->password =
        Hash::make($this->password);
    }
    public function render()
    {
        return view('livewire.user.user-overview.show-user');
    }
    public function store(){
        // Validate Form Request
        //$this->validate();
        try{
        User::updateOrCreate(
        [
            'man_no' => $this->StaffNumber
        ],
        [
            'name' => $this->name,
            'position' => $this->Position,
            'division' => $this->Division,
            'grade' => $this->EmployeeGrade,

            'email' => $this->StaffEmail,
            'status'=> 0,

            'location' => $this->Department,
            'man_no' => $this->StaffNumber,
            'directorate' => $this->Directorate,
            'password' => Hash::make($this->password)
        ]
            );

            // Set Flash Message
            session()->flash('success','User updated Successfully!!');
            // Reset Form Fields After Creating Config Destination
            $this->resetFields();
        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating updating the records!!');
            // Reset Form Fields After Creating Config Destination
            //$this->resetFields();
        }
    }
}
