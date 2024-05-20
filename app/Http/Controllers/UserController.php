<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $data = [
			'title'=>'User list',
			'viewurl' =>route('admin.users.create'),
			'editurl'=>'admin.edit.users',
			'list'=> Admin::select('admins.*', 'roles.name as role_name')
            ->leftJoin('roles', 'admins.role_id', '=', 'roles.id')
            ->orderBy('admins.id', 'desc')
            ->paginate(10),
		];
        return view('admin.users',$data);
    }
    

    public function createUser(Request $request)
    {
        $data = [
		    'title'=>'Add New User',
			'backtrack'=> 'admin.users.list',
			'url_action' => route('admin.users.postcreate'),
            'roles'=>Role::orderBy('id','desc')->get(),
			"obj"=>'',
		];
        return view('admin.adminuser',$data);
    }

    public function postCreateUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email has already been taken.',
            'password.required' => 'The password field is required.',
           
            'password_confirmation.required' => 'The password confirmation field is required.',
        ]);

          // Create a new user record
            $user = new Admin;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role;
            $user->designation = $request->designation;
            $user->status = $request->status??0;
            $user->password = bcrypt($request->password); // Make sure to hash the password
            $user->save();

            // Redirect the user or do something else
            return redirect()->back()->with('success', 'Registration successful.');

    }

    public function editUser($id)
    {
        $editdata = Admin::find($id);
        if($editdata == null)
        {
            return 'no data';
        }
        $data = [
        'url_action'=> route('admin.update.users',['id'=>$editdata['id']]),
        'backtrack'=> 'admin.users.list',
        'title'=>'Edit User',
        'obj'=>$editdata,
        'roles'=>Role::orderBy('id','desc')->get(),
        ];
        return view('admin.adminuser',$data);
    }

    public function postEditUser(Request $request ,$id)
    {
        $user  = Admin::find($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $user->id,
            // Only require password and password confirmation if either is filled
            'password' => $request->filled('password') ? 'required|confirmed' : '',
            'password_confirmation' => $request->filled('password') ? 'required' : '',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email has already been taken.',
            'password.required' => 'The password field is required.',  
            'password_confirmation.required' => 'The password confirmation field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

         // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->designation = $request->designation;
        $user->status = $request->status ?? 0;
        
        // Only update password if it's filled
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Make sure to hash the password
        }

        $user->save();

        // Redirect the user or do something else
        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        
        if ($id) {
            $obj =  Admin::find($id);
            if($obj['name'] =='admin')
            {
                $output['res'] = 'error';
                $output['msg'] = 'Not Allowed';
            }else{
                $obj->delete();
                $output['res'] = 'success';
                $output['msg'] = 'Data Deleted';
            }
            } 
            else
            {
                $output['res'] = 'error';
                $output['msg'] = 'User Id Required';
            }
        echo json_encode($output);
    }
}
