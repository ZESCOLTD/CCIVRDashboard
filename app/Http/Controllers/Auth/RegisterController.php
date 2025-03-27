<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PhrisUserDetails;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => ['required', 'string', 'max:255'],
            'man_no' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $phris_user_details = PhrisUserDetails::select('con_per_no', 'name')
            ->where('con_per_no', $request->man_no)
            ->where('con_st_code', 'ACT')
            ->first();

        // dd($phris_user_details);

        if (empty($phris_user_details)) {
            return redirect()->back()->withInput()->withErrors(['man_no' => "Sorry! man number does not exists in PHCMS or is Inactive"]);
        } else {
            // CREATE THE USER
            event(new Registered($user = $this->create($request->all())));

            //login the user
            $this->guard()->login($user);

            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $request)
    {
        $phris = PhrisUserDetails::where('con_per_no', $request['man_no'])
            ->first();

        $data = $phris->toArray();
        $data['man_no'] = $phris->con_per_no;
        $data['email'] = str_replace("payroll-reports@zesco.co.zm", null, trim(strtolower($phris->staff_email))) ?? strtolower($request['email']);
        $data['password'] = Hash::make($request['password']);


        //dd($data);
        $user = User::updateOrCreate(
            [
                'man_no' => $phris->con_per_no,
            ],
            $data
        );

        $data['token'] =  $user->createToken('MyApp')->plainTextToken;
        return   $user;
    }
}
