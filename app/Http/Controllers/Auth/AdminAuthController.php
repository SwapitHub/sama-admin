<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;

class AdminAuthController extends Controller
{
    public function authenticate(Request $request) {

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'The Email field is required.',
            'password.required' => 'The Password field is required.',
        ]);
		
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->get('remember'))) {
            return redirect()->route('admin.dashboard');
        } else {
            session()->flash('error','Try again, invalid login credentials');
            return back()->withInput($request->only('email'));
        }

    }

    public function logout() {
        Auth::guard('admin')->logout();
        $isLoggedOut = !Auth::guard('admin')->check();

        if ($isLoggedOut) {
            $output['res'] = 'success';
            $output['msg'] = 'Logout successful';
            $output['redirect_url'] = route('admin.login');
        } else {
            $output['res'] = 'error';
            $output['msg'] = 'Error during logout';
            $output['redirect_url'] = null;
        }
        echo json_encode($output);

        // return redirect()->route('admin.login');
    }
}
