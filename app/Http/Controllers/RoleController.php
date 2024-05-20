<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $rolesData = DB::table('roles')->orderBy('id', 'desc')->paginate(10);

        // Process each role data to fetch permission names
        foreach ($rolesData as $role) {
            // Split the comma-separated permission IDs
            $permissionIds = explode(',', $role->permissions);
            
            // Fetch permission names for each permission ID
            $permissionNames = DB::table('permissions')
                ->whereIn('id', $permissionIds)
                ->pluck('name')
                ->toArray();
            
            // Concatenate permission names
            $role->permission_names = implode(', ', $permissionNames);
        }

        $data = [
			'title'=>'Role list',
			'viewurl' =>route('admin.role.create'),
			'editurl'=>'admin.role.edit',
			'list'=> $rolesData
		];
        return view('admin.role_list',$data);
    }
    
    public function addRole()
    {
        $data = [
		    'title'=>'Add User Role',
			'backtrack'=> 'admin.role.list',
			'url_action' => route('admin.role.postcreate'),
            'permission'=>Permission::orderBy('id','desc')->get(),
			"obj"=>'',
		];
        return view('admin.roles',$data);
    }
    public function postaddRole(Request $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->permissions = implode(',',$request->permissions);
        $role->save();
        return redirect()->back()->with('success', 'Role added');     
    }

    public function editRole($id)
    {
        $editdata = Role::find($id);
        if($editdata == null)
        {
            return 'no data';
        }
        $data = [
			'url_action'=> route('admin.role.update',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.role.list',
			'title'=>'Edit User Role',
			'obj'=>$editdata,
            'permission'=>Permission::orderBy('id','desc')->get(),
		];
        return view('admin.roles',$data);

    }

    public function postEditRole(Request $request,$id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->permissions = implode(',',$request->permissions);
        $role->save();
        return redirect()->back()->with('success', 'Role updated');
    }
}
