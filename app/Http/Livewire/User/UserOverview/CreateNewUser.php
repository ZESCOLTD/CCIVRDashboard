<?php

namespace App\Http\Livewire\User\UserOverview;

use App\Models\PhrisUserDetails;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateNewUser extends Component
{
    public User $user;
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

    public $phrisSearchResults = []; // Stores the collection of PhrisUserDetails for the select dropdown

    protected $rules = [
        'StaffNumber' => 'required',
        'StaffEmail' => 'required|email',
        'password' => 'required|min:6',
    ];


    public function updatedStaffNumber()
    {
        $searchQuery = trim($this->StaffNumber); // Remove leading/trailing whitespace

        if (empty($searchQuery) || strlen($searchQuery) <= 3) { // Optional: require minimum 3 characters for search
            return;
        }
        $this->phrisSearchResults = PhrisUserDetails::where('con_per_no', 'like', '%' . $searchQuery . '%')
            ->orWhere('name', 'like', '%' . $searchQuery . '%') // Also search by name
            ->limit(10) // Limit results to avoid overwhelming the client
            ->get();
        // dd($this->phrisSearchResults);
        // return $this->StaffNumber;
    }

    public function updatedSelectedEmployee($value)
    {
        // dd($value);
        if ($this->selectedEmployee) {

            $newUserPhris = PhrisUserDetails::where('con_per_no', $value)->first();

            //            #attributes: array:27 [▼
            //            "con_per_no" => "72699"
            //    "alt_per_no" => null
            //    "contract_type" => "PERMANENT CONTRACT"
            //    "con_st_code" => "ACT"
            //    "con_wef_date" => "2016-01-04 00:00:00"
            //    "con_wet_date" => "2049-07-06 00:00:00"
            //    "name" => "KELLY  KINYAMA"
            //    "nrc" => "141691/10/1"
            //    "group_type" => "UNIONISED"
            //    "job_title" => "TELECOMMS ASSISTANT"
            //    "grade" => "GP7"
            //    "functional_section" => "TELECOMS"
            //    "directorate" => "CORPORATE SUPPORT SERVICES DIRECTORATE"
            //    "location" => "FIBRECOM"
            //    "pay_point" => "CORPORATE SUPPORT SERVICES"
            //    "bu_code" => "12500"
            //    "cc_code" => "12240"
            //    "staff_email" => "KKINYAMA@ZESCO.CO.ZM"
            //    "job_code" => "TELECOMMS ASSISTANT"
            //    "dob" => "1989-07-07 00:00:00"
            //    "sex" => "M"
            //    "mobile_no" => "260972462922"
            //    "station" => "LUSAKA"
            //    "union_affiliation" => null
            //    "account_number" => "0000001014476"
            //    "branch_code" => "021451"
            //    "bank_code" => "02"
            //  ]

            //dd($newUserPhris);
            $this->name = $newUserPhris->name;
            $this->Position = $newUserPhris->job_title;
            $this->Division = $newUserPhris->functional_section;
            $this->EmployeeGrade = $newUserPhris->grade;

            $this->StaffEmail = $newUserPhris->staff_email;

            $this->Department = $newUserPhris->location;
            $this->StaffNumber = $newUserPhris->con_per_no;
            $this->Directorate = $newUserPhris->directorate;

            //            $this->user->name = $newUserPhris->name;
        }
    }

    public function render()
    {
        return view('livewire.user.user-overview.create-new-user');
    }

    // public function submit()
    // {
    //     // Validate Form Request
    //     //$this->validate();
    //     try {
    //         // Create Config Destination
    //         User::updateOrCreate(
    //             [
    //                 'man_no' => $this->StaffNumber
    //             ],
    //             [
    //                 'name' => $this->name,
    //                 'position' => $this->Position,
    //                 'division' => $this->Division,
    //                 'grade' => $this->EmployeeGrade,

    //                 'email' => $this->StaffEmail,
    //                 'status'=> 0,

    //                 'location' => $this->Department,
    //                 'man_no' => $this->StaffNumber,
    //                 'directorate' => $this->Directorate,
    //                 'password' => Hash::make($this->password)
    //             ]

    //         );

    //         // Set Flash Message
    //         session()->flash('success', 'User Created Successfully!!');
    //         // Reset Form Fields After Creating Config Destination
    //         $this->resetFields();
    //     } catch (\Exception $e) {
    //         // Set Flash Message
    //         //dd($e);
    //         session()->flash('error', 'Something goes wrong while creating user!!'.$e->getMessage());
    //         // Reset Form Fields After Creating Config Destination
    //         $this->resetFields();
    //     }
    // }

    public function submit()
    {
        // Validate required fields
        // Validate Form Request
        $this->validate();

        try {
            // Check if user already exists
            if (User::where('man_no', $this->StaffNumber)->exists()) {
                session()->flash('error', 'User already exists with staff number: ' . $this->StaffNumber);
                $this->resetFields();
                return;
            }
            // Attempt to find user details in the PhrisUserDetails table
            $newUserPhris = PhrisUserDetails::where('con_per_no', $this->StaffNumber)->first();

            // Check if the staff number exists in PhrisUserDetails
            // If $newUserPhris is null, it means no matching record was found in PhrisUserDetails
            if (!$newUserPhris) {
                session()->flash('error', 'Staff number ' . $this->StaffNumber . ' not found in Phris records or is invalid.');
                $this->resetFields();
                return;
            }


            // Create new user
            User::create([
                'name' => $this->name,
                'position' => $this->Position,
                'division' => $this->Division,
                'grade' => $this->EmployeeGrade,
                'email' => $this->StaffEmail,
                'status' => 0,
                'location' => $this->Department,
                'man_no' => $this->StaffNumber,
                'directorate' => $this->Directorate,
                'password' => Hash::make($this->password),
            ]);

            session()->flash('success', 'User created successfully!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->name = '';
        $this->Position = '';
        $this->Division = '';
        $this->EmployeeGrade = '';

        $this->StaffEmail = '';

        $this->Department = '';
        $this->StaffNumber = '';
        $this->Directorate = '';
        $this->password = '';
        $this->selectedEmployee = '';
    }
}
