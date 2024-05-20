<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\SiteInfo;

class SiteinfoController extends Controller
{
    public function index()
    {
        $siteinfo = SiteInfo::first();
        $data = [
            'title' => 'Site Information',
            'siteinfo' => $siteinfo,
        ];
        return view('admin.siteinfo', $data);
    }

    public function update_siteinfo(Request $request)
    {
        $siteinfo = SiteInfo::find($request->id);
        $this->validate($request, [
            'id' => 'required',
            'sitename' => 'required',
        ], [
            'id.required' => 'The id field is required.',
            'sitename.required' => 'The site name field is required.',
        ]);

        if ($request->file('logo') != NULL) {
            $oldImagePath = $siteinfo->logo;
            if ($oldImagePath) {
                $oldImagePath = 'public/storage/' . $oldImagePath;
                Storage::disk('s3')->delete($oldImagePath);
            }
            // insert new image in folder and update it to database
            $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('public/storage/images', $fileName, 's3');
            $logopath = 'images/' . $fileName;
            Storage::disk('s3')->setVisibility($path, 'public');
        } else {
            $logopath = $siteinfo->logo;
        }


        if ($request->file('favicon') != NULL) {
            $oldImagePath =  $siteinfo->favicon; // Replace with the actual path
            if (($oldImagePath)) {
                Storage::disk('s3')->delete($oldImagePath);
            }
            $fileName = time() . '_' . $request->file('favicon')->getClientOriginalName();
            $path = $request->file('favicon')->storeAs('public/storage/images', $fileName, 's3');
            $faviconpath = 'images/' . $fileName;
            Storage::disk('s3')->setVisibility($path, 'public');
        }
        else
        {
            $faviconpath = $siteinfo->favicon;;
        }

        $siteinfo->name = $request->sitename;
        $siteinfo->email = $request->email;
        $siteinfo->phone = $request->phone;
        $siteinfo->logo = $logopath;
        $siteinfo->favicon = $faviconpath;
        $siteinfo->address = $request->address;
        $siteinfo->copyright = $request->copyright;
        $siteinfo->save();
        return redirect()->back()->with('success', 'Site information updated successfully.');
    }

    public function updatesite_urls(Request $request)
    {
        $siteinfo = SiteInfo::find($request->id);
        $siteinfo->facebook = $request->facebook;
        $siteinfo->instagram = $request->instagram;
        $siteinfo->twitter = $request->twitter;
        $siteinfo->pinterest = $request->pinterest;
        $siteinfo->linkedin = $request->linkedin;
        $siteinfo->youtube = $request->youtube;
        $siteinfo->save();
        $output['res'] = 'success';
        $output['msg'] = 'Social media url updated';
        echo json_encode($output);
    }
}
