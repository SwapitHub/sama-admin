<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\gemstoneModel;
use App\Models\gemstoneShapeModel;
use App\Models\gemstoneColorModel;

class GemstoneAttributeController extends Controller
{
    public function gemstones()
    {
        $data = [
			"title"=>'Gemstone list',
			"viewurl" => 'admin.gemstone.add',
			"editurl" =>'admin.gemstone.edit',
			'list'=> gemstoneModel::orderBy('id','desc')->get(),
			];
			return view('admin.gemstoneList',$data);
    }

    public function addGemstone()
    {
        $data = [
			'url_action' => route('admin.gemstone.store'),
			'backtrack'=> 'admin.gemstone.list',
			'title'=>'Add Gemstone',
			"obj"=>'',
			];
			return view('admin.gemstone',$data);
    }

    public function gemstoneStore(Request $request)
    { 
			$this->validate($request, [
                'name' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
                ], [
                'title.required' => 'The banner title field is required.',
                'image.required' => 'An image is required.',
                'image.image' => 'The uploaded file must be an image.',
                'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
                'image.max' => 'The image size must not exceed 5 MB.',
                ]);
                
                if ($request->file('image') != NULL) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = "gemstone_" . time() . '.' . $extension;
                    $path = $request->file('image')->storeAs('public/images', $fileName);
                    $bannerpath = 'images/' . $fileName;
                }
                $stone = new gemstoneModel;
                $stone->name = $request->name;
                $stone->image = $bannerpath;
                $stone->status = $request->status ?? 'false';
                $stone->save();
                return redirect()->back()->with('success', 'Data added successfully');
    }

    public function gemstoneEdit($id)
    {
            $editdata = gemstoneModel::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.gemstone.update',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.gemstone.list',
			'title'=>'Edit Gamstone',
			'obj'=>$editdata,
			];
			return view('admin.gemstone',$data);
    }

    public function gemstoneUpdate(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The Name fiels is required.',
			]);
			$stonedata = gemstoneModel::find($request->id);
			if ($request->file('image') != NULL) {
				$oldImagePath = 'public/' . $stonedata->image; 
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "gemstone_" . time() . '.' . $extension;
                
				$path = $request->file('image')->storeAs('public/images', $fileName);
				$bannerpath = 'images/' . $fileName;
			}else{
			    $bannerpath = $stonedata->image;
			}
			
			$stonedata->name = $request->name;
			$stonedata->image = $bannerpath;
			$stonedata->status = $request->status ?? 'false';
			$stonedata->save();
			return redirect()->back()->with('success', 'Data updated successfully');
    }

    public function deleteGemstone($id)
    {
        if ($id) {
            $carat = gemstoneModel::find($id);
            $carat->delete();
            $output['res'] = 'success';
            $output['msg'] = 'Data Deleted';
            } else {
            $output['res'] = 'error';
            $output['msg'] = 'Carat Id Required';
        }
        echo json_encode($output);	
    }


    ############# Stone shape start ################ 

    public function stoneShape()
    {
        $data = [
			"title"=>'Gemstone Shape list',
			"viewurl" => 'admin.shape.add',
			"editurl" =>'admin.shape.edit',
			'list'=> gemstoneShapeModel::orderBy('id','desc')->get(),
			];
			return view('admin.stoneshapeList',$data);
    }

    public function addStoneShape()
    {
        $data = [
			'url_action' => route('admin.shape.store'),
			'backtrack'=> 'admin.shape.list',
			'title'=>'Add Gemstone Shape',
			"obj"=>'',
			];
			return view('admin.stoneshape',$data);
    }

    public function stoneShapeStore(Request $request)
    { 
			$this->validate($request, [
                'name' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
                ], [
                'title.required' => 'The banner title field is required.',
                'image.required' => 'An image is required.',
                'image.image' => 'The uploaded file must be an image.',
                'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
                'image.max' => 'The image size must not exceed 5 MB.',
                ]);
                
                if ($request->file('image') != NULL) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = "gemstone_" . time() . '.' . $extension;
                    $path = $request->file('image')->storeAs('public/images', $fileName);
                    $bannerpath = 'images/' . $fileName;
                }
                $stone = new gemstoneShapeModel;
                $stone->name = $request->name;
                $stone->image = $bannerpath;
                $stone->status = $request->status ?? 'false';
                $stone->save();
                return redirect()->back()->with('success', 'Data added successfully');
    }

    public function stoneShapeEdit($id)
    {
            $editdata = gemstoneShapeModel::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.shape.update',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.shape.list',
			'title'=>'Edit Gamstone Shape',
			'obj'=>$editdata,
			];
			return view('admin.stoneshape',$data);
    }

    public function stoneShapeUpdate(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The Name fiels is required.',
			]);
			$stonedata = gemstoneShapeModel::find($request->id);
			if ($request->file('image') != NULL) {
				$oldImagePath = 'public/' . $stonedata->image; 
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "gemstone_" . time() . '.' . $extension;
                
				$path = $request->file('image')->storeAs('public/images', $fileName);
				$bannerpath = 'images/' . $fileName;
			}else{
			    $bannerpath = $stonedata->image;
			}
			
			$stonedata->name = $request->name;
			$stonedata->image = $bannerpath;
			$stonedata->status = $request->status ?? 'false';
			$stonedata->save();
			return redirect()->back()->with('success', 'Data updated successfully');
    }

    public function stoneShapeDelete($id)
    {
        if ($id) {
            $carat = gemstoneShapeModel::find($id);
            $carat->delete();
            $output['res'] = 'success';
            $output['msg'] = 'Data Deleted';
            } else {
            $output['res'] = 'error';
            $output['msg'] = 'Id Required';
        }
        echo json_encode($output);	
    }

    ############# Stone shape end ################ 

    ############# Stone color start ################ 

    public function stoneColor()
    {
        $data = [
			"title"=>'Gemstone color list',
			"viewurl" => 'admin.color.add',
			"editurl" =>'admin.color.edit',
			'list'=> gemstoneColorModel::orderBy('id','desc')->get(),
			];
			return view('admin.stonecolorList',$data);
    }

    public function addStoneColor()
    {
        $data = [
			'url_action' => route('admin.color.store'),
			'backtrack'=> 'admin.color.list',
			'title'=>'Add Gemstone Color',
			"obj"=>'',
			];
			return view('admin.stonecolor',$data);
    }

    public function stoneColorStore(Request $request)
    { 
			$this->validate($request, [
                'name' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
                ], [
                'title.required' => 'The banner title field is required.',
                'image.required' => 'An image is required.',
                'image.image' => 'The uploaded file must be an image.',
                'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
                'image.max' => 'The image size must not exceed 5 MB.',
                ]);
                
                if ($request->file('image') != NULL) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = "gemstone_" . time() . '.' . $extension;
                    $path = $request->file('image')->storeAs('public/images', $fileName);
                    $bannerpath = 'images/' . $fileName;
                }
                $stone = new gemstoneColorModel;
                $stone->name = $request->name;
                $stone->image = $bannerpath;
                $stone->status = $request->status ?? 'false';
                $stone->save();
                return redirect()->back()->with('success', 'Data added successfully');
    }

    public function stoneColorEdit($id)
    {
            $editdata = gemstoneColorModel::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.color.update',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.color.list',
			'title'=>'Edit Gamstone Color',
			'obj'=>$editdata,
			];
			return view('admin.stonecolor',$data);
    }

    public function stoneColorUpdate(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The Name fiels is required.',
			]);
			$stonedata = gemstoneColorModel::find($request->id);
			if ($request->file('image') != NULL) {
				$oldImagePath = 'public/' . $stonedata->image; 
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "gemstone_" . time() . '.' . $extension;
                
				$path = $request->file('image')->storeAs('public/images', $fileName);
				$bannerpath = 'images/' . $fileName;
			}else{
			    $bannerpath = $stonedata->image;
			}
			
			$stonedata->name = $request->name;
			$stonedata->image = $bannerpath;
			$stonedata->status = $request->status ?? 'false';
			$stonedata->save();
			return redirect()->back()->with('success', 'Data updated successfully');
    }

    public function stoneColorDelete($id)
    {
        if ($id) {
            $carat = gemstoneColorModel::find($id);
            $carat->delete();
            $output['res'] = 'success';
            $output['msg'] = 'Data Deleted';
            } else {
            $output['res'] = 'error';
            $output['msg'] = 'Id Required';
        }
        echo json_encode($output);	
    }

    ############# Stone color end ################ 

}
