<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // No auto-login: send the new user to the login page to sign in
    public function register(\Illuminate\Http\Request $request)
    {
        $this->validator($request->all())->validate();
        event(new \Illuminate\Auth\Events\Registered($this->create($request->all())));

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil. Silakan masuk.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^08[0-9]{8,13}$/', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['phone'] . '@placeholder.local', // Generate dummy email
            'password' => Hash::make($data['password']),
        ]);
    }
}
