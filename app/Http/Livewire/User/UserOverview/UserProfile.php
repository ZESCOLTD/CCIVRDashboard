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
//      dd($user = User::find((int)$userId));
        $user = User::find((int)$userId);
//        return view('livewire.user.profile')->with(compact('user'));
        return view('livewire.user.user-overview.user-profile')->with(compact('user'));

    }

//    public function resetPassword()
//    {
//        try {
//
//            if (empty($this->otp) || strlen($this->otp) < 8) {
//                session()->flash('error', 'Password must be atleast 8 characters long, must include at least, a number, special character, upper case and lower cas e!');
//            } elseif ($this->otp == 'Zesco123' || $this->otp == 'zesco123' || $this->otp == 'zesco@123' ||
//                $this->otp == 'Zesco@123' || $this->otp == 'Zesco12345' || $this->otp == 'zesco12345') {
//                session()->flash('error', 'Sorry your new password has been listed as a commonly used password. Therefore it does not meet the Password Policy. Please change to another password.');
//            } else {
//                $userId = ParameterEncryption::decrypt($this->profile);
//                $user = User::find((int)$userId);
//                $user->password = Hash::make($this->otp);
//                $user->save();
//
//                session()->flash('message', 'Password Reset Successful');
//            }
//        } catch (\Exception $e) {
//            //throw $th;
//            Log::error($e);
//            session()->flash('error', 'Something went wrong while attempting to reset password !  ' . $e->getMessage());
//        }
//
//    }

    public function resetPassword()
    {
        try {
            // Validate password length and strength
            if (empty($this->otp) || strlen($this->otp) < 12 ||
                !preg_match('/[A-Z]/', $this->otp) || // At least one uppercase
                !preg_match('/[a-z]/', $this->otp) || // At least one lowercase
                !preg_match('/[0-9]/', $this->otp) || // At least one digit
                !preg_match('/[\W]/', $this->otp)) {  // At least one special character
                session()->flash('error', 'Password must be at least 12 characters long and include upper case, lower case, number, and special character.');
                return;
            }

            // List of disallowed (compromised or weak) passwords
            $commonPasswords = [
                'Zesco123', 'zesco123', 'zesco@123',
                'Zesco@123', 'Zesco12345', 'zesco12345',
                'welcome123', 'Welcome12345!','Welcome12345'
            ];

            if (in_array($this->otp, $commonPasswords)) {
                session()->flash('error', 'This password is too common or compromised. Please use a stronger, unique password.');
                return;
            }

            $userId = ParameterEncryption::decrypt($this->profile);
            $user = User::find((int)$userId);

            // Check if password has been used before (assuming password history is tracked)
            $previousPasswords = \DB::table('password_histories')
                ->where('user_id', $user->id)
                ->pluck('password');

            foreach ($previousPasswords as $oldHash) {
                if (Hash::check($this->otp, $oldHash)) {
                    session()->flash('error', 'You have used this password before. Please choose a new password.');
                    return;
                }
            }

            // Save the new password
            $newHashedPassword = Hash::make($this->otp);
            $user->password = $newHashedPassword;
            $user->force_password_reset = false;
            $user->save();

            // Store in password history
            \DB::table('password_histories')->insert([
                'user_id'    => $user->id,
                'password'   => $newHashedPassword,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->flash('message', 'Password Reset Successful');
        } catch (\Exception $e) {
            Log::error($e);
            session()->flash('error', 'Something went wrong while attempting to reset password! ' . $e->getMessage());
        }
    }

}
