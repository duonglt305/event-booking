<?php

namespace DG\Dissertation\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Models\Organizer;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/organizer/dashboard';

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:organizers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'min:10', 'unique:organizers'],
            'address' => ['required', 'string', 'min:10'],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Organizer::create([
            'name' => $data['name'],
            'slug' => \Str::slug($data['name']),
            'email' => $data['email'],
            'password' => \Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'description' => $data['description'],
            'website' => $data['website']
        ]);
    }


    public function showRegistrationForm()
    {
        return view('admin::auth.register');
    }
}
