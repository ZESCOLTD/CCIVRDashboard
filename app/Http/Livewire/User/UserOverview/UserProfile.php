<?php

namespace App\Http\Livewire\User\UserOverview;

use App\Models\User;
use App\Services\Security\ParameterEncryption;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserProfile extends Component
{
    public $profile;
    public $otp;
    protected $queryString = ['profile'];

    public function render()
    {
        $userId = ParameterEncryption::decrypt($this->profile);

        $user = User::find((int)$userId);
        return view('livewire.user.user-profile')->with(compact('user'));
    }

    public function resetPassword()
    {
        try {

            if (empty($this->otp) || strlen($this->otp) < 8) {
                session()->flash('error', 'Password must be atleast 8 characters long, must include at least, a number, special character, upper case and lower cas e!');
            } elseif ($this->otp == 'Zesco123' || $this->otp == 'zesco123' || $this->otp == 'zesco@123' ||
                $this->otp == 'Zesco@123' || $this->otp == 'Zesco12345' || $this->otp == 'zesco12345') {
                session()->flash('error', 'Sorry your new password has been listed as a commonly used password. Therefore it does not meet the Password Policy. Please change to another password.');
            } else {
                $userId = ParameterEncryption::decrypt($this->profile);
                $user = User::find((int)$userId);
                $user->password = Hash::make($this->otp);
                $user->save();

                session()->flash('message', 'Password Reset Successful');
            }
        } catch (\Exception $e) {
            //throw $th;
            Log::error($e);
            session()->flash('error', 'Something went wrong while attempting to reset password !  ' . $e->getMessage());
        }

    }
}
