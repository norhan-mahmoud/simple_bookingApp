<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->type === 'admin') {
                return redirect()->intended(route('admin.rooms'));
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Access denied for non-admin users.']);
            }
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function userLogin(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('rooms'));
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
}
