<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticated(Request $request)
    {

        // if(Auth::check()){
        //     return redirect(route('employees.index'));
        // }

        if (preg_match('/^\d{4}-\d$/', $request->email)) {
            $login = Employee::where('registration', $request->email)->first();
            $credentials = $login?->user ? ['email' => $login->user->email, 'password' => $request->password] : null;
        } elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $credentials = $request->only('email', 'password');
        } else {
            $credentials = null;
        }

        if ($credentials && Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('employees.index'));
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas',
        ]);
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));

    }
}
