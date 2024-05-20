<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $data['menus'] = Menu::orderBy('id', 'desc')->paginate(10);
        return view('admin/menuList', $data);
    }

    public function createMenuView()
    {
        return view('admin/createmenu');
    }
    public function postCreateMenu(Request $request)
    {
        $this->validate($request, [
            'menuname' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048', // Adjust mime types and max size as needed
        ], [
            'menuname.required' => 'The menu name field is required.',
            'image.required' => 'An image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
            'image.max' => 'The image size must not exceed 5 MB.',
        ]);

        if ($request->file('image') != NULL) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = "langicon_" . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/storage/images/menus', $fileName, 's3');
            $image_path = 'images/menus/' . $fileName;
            Storage::disk('s3')->setVisibility($path, 'public');
        }
        $menu = new Menu;
        $menu->name = $request->menuname;
        $uniqueslug = $request->slug ?? $request->menuname;
        $slug = $menu->generateUniqueSlug($uniqueslug);
        $menu->slug = $slug;
        $menu->image = $image_path;
        $menu->term_condition = $request->term_condition;
        $menu->order_number = $request->order_number;
        $menu->status = $request->status ?? 'false';
        $menu->save();
        return redirect()->back()->with('success', 'Menu added successfully');
    }

    public function editMenu($id)
    {
        $data['menudata'] = Menu::find($id);
        return view('admin.editmenu', $data);
    }

    public function postEditMenu(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'menuname' => 'required',
        ], [
            'id.required' => 'The menu id field is required.',
            'menuname.required' => 'The menu name field is required.',
        ]);
        $menu =  Menu::find($request->id);
        if ($request->file('image') != NULL) {
            $oldImagePath = $menu->image;
            if ($oldImagePath) {
                $oldImagePath = 'public/storage/'.$oldImagePath;
                Storage::disk('s3')->delete($oldImagePath);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = "langicon_" . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/storage/images/menus', $fileName, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $image_path = 'images/menus/' . $fileName;
        } else {
            $image_path = $menu->image;
        }
        $menu->name = $request->menuname;
        if ($request->slug) {
            $slug = $menu->generateUniqueSlug($request->slug);
        } else {
            $slug = $menu->slug;
        }
        $menu->slug = $slug;
        $menu->image = $image_path;
        $menu->term_condition = $request->term_condition;
        $menu->order_number = $request->order_number;
        $menu->status = $request->status ?? 'false';
        $menu->save();
        return redirect()->back()->with('success', 'Menu updated successfully');
    }

    public function deleteMenu($id)
    {
        if ($id) {
            $menudata = Menu::find($id);
            $oldImagePath = 'public/' . $menudata->image; // Replace with the actual path
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
            $menudata->delete();
            $output['res'] = 'success';
            $output['msg'] = 'Data Deleted';
        } else {
            $output['res'] = 'error';
            $output['msg'] = 'Menu Id Required';
        }
        echo json_encode($output);
    }
}
