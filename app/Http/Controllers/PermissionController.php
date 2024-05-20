<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    public function index()
    {
        
        $data = [
			'title'=>'Permission list',
			'viewurl' =>route('admin.permission.create'),
			'editurl'=>'admin.edit.permission',
			'list'=> Permission::orderBy('id','desc')->paginate(10),
		];
        return view('admin.permission_list',$data);
    }

    public function addPermission()
    {
        $routes = collect(Route::getRoutes());
        $routeData = $routes->reject(function ($route) {
            return !$route->getName();
        })->map(function ($route) {
            $methods = array_diff($route->methods(), ['HEAD']);
            return [
                'name' => $route->getName(),
                'method' => $methods[0],
                'uri' => $route->uri(),
            ];
        });
        
        $data = [
		    'title'=>'Add New Permission',
			'backtrack'=> 'admin.permission.list',
			'url_action' => route('admin.users.postadd'),
            'route_list'=>$routeData,
			"obj"=>'',
		];
        return view('admin.permission',$data);
    }

    public function postAdd(Request $request)
    {
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->slug = $request->slug??$permission->generateUniqueSlug($request->name);
        $permission->permissions = implode('###',$request->permissions);
        $permission->save();
        return redirect()->back()->with('success', 'Permission added');     
    }

    public function editPermission($id)
    {
           $editdata = Permission::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
            $routes = collect(Route::getRoutes());
            $routeData = $routes->reject(function ($route) {
                return !$route->getName();
            })->map(function ($route) {
                $methods = array_diff($route->methods(), ['HEAD']);
                return [
                    'name' => $route->getName(),
                    'method' => $methods[0],
                    'uri' => $route->uri(),
                ];
            });
			$data = [
			'url_action'=> route('admin.update.permission',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.permission.list',
			'title'=>'Edit Permission',
			'obj'=>$editdata,
            'route_list'=>$routeData
			];
			return view('admin.permission',$data);
    }

    public function postEditPermission(Request $request,$id)
    {
        $permission = Permission::find($id);
        if($request->slug)
        {
           $slug =  $permission->generateUniqueSlug($request->slug);
        }else
        {
            $slug = $permission->slug;
        }
        $permission->name = $request->name;
        $permission->slug = $slug;
        $permission->permissions = implode('###',$request->permissions);
        $permission->save();
        return redirect()->back()->with('success', 'Permission updated');   
    }

}
