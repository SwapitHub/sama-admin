<?php

	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Storage;
	use App\Models\HomeContent;

	class HomeContentController extends Controller
	{
	    public function index()
		{
			$data = [
			"title"=>'Faqs',
			"url_action"=>route('admin.homecontent.update'),
			"obj"=> HomeContent::find(1)
			];
			return view('admin.homecontant',$data);
		}

		public function update(Request $request)
		{
			// get all the images
			$homecontant = HomeContent::find(1);
			// main_banner
			if ($request->file('main_banner') != NULL) {
				$oldImagePath = $homecontant->main_banner; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('main_banner')->getClientOriginalExtension();
				$fileName = "main_banner_" . time() . '.' . $extension;
				$path = $request->file('main_banner')->storeAs('public/storage/images/homeContent', $fileName,'s3');

				$main_banner = 'images/homeContent/' . $fileName;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $main_banner = $homecontant->main_banner;
			}



			// sale banner
			if ($request->file('sale_banner') != NULL) {
				$oldImagePath = $homecontant->sale_banner; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('sale_banner')->getClientOriginalExtension();
				$fileName_sale = "sale_banner_" . time() . '.' . $extension;
				$path = $request->file('sale_banner')->storeAs('public/storage/images/homeContent', $fileName_sale,'s3');
				$sale_banner = 'images/homeContent/' . $fileName_sale;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $sale_banner = $homecontant->sale_banner;
			}

			// ring_promotion_banner_desktop_1
			if ($request->file('ring_promotion_banner_desktop_1') != NULL) {
				$oldImagePath = $homecontant->ring_promotion_banner_desktop_1; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('ring_promotion_banner_desktop_1')->getClientOriginalExtension();
				$fileName_ring_promotion_banner_desktop_1 = "ring_promotion_banner_desktop_1_" . time() . '.' . $extension;
				$path = $request->file('ring_promotion_banner_desktop_1')->storeAs('public/storage/images/homeContent', $fileName_ring_promotion_banner_desktop_1, 's3');
				$ring_promotion_banner_desktop_1 = 'images/homeContent/' . $fileName_ring_promotion_banner_desktop_1;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $ring_promotion_banner_desktop_1 = $homecontant->ring_promotion_banner_desktop_1;
			}


			// ring_promotion_banner_mobile_1
			if ($request->file('ring_promotion_banner_mobile_1') != NULL) {
				$oldImagePath = $homecontant->ring_promotion_banner_mobile_1; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('ring_promotion_banner_mobile_1')->getClientOriginalExtension();
				$fileName_ring_promotion_banner_mobile_1 = "ring_promotion_banner_mobile_1_" . time() . '.' . $extension;
				$path = $request->file('ring_promotion_banner_mobile_1')->storeAs('public/storage/images/homeContent', $fileName_ring_promotion_banner_mobile_1);
				$ring_promotion_banner_mobile_1 = 'images/homeContent/' . $fileName_ring_promotion_banner_mobile_1;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $ring_promotion_banner_mobile_1 = $homecontant->ring_promotion_banner_mobile_1;
			}

			//ring_promotion_banner_desktop_2
			if ($request->file('ring_promotion_banner_desktop_2') != NULL) {
				$oldImagePath = $homecontant->ring_promotion_banner_desktop_2; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('ring_promotion_banner_desktop_2')->getClientOriginalExtension();
				$fileName_ring_promotion_banner_desktop_2 = "ring_promotion_banner_desktop_2_" . time() . '.' . $extension;
				$path = $request->file('ring_promotion_banner_desktop_2')->storeAs('public/storage/images/homeContent', $fileName_ring_promotion_banner_desktop_2, 's3');
				$ring_promotion_banner_desktop_2 = 'images/homeContent/' . $fileName_ring_promotion_banner_desktop_2;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $ring_promotion_banner_desktop_2 = $homecontant->ring_promotion_banner_desktop_2;
			}

			//ring_promotion_banner_mobile_2
			if ($request->file('ring_promotion_banner_mobile_2') != NULL) {
				$oldImagePath = $homecontant->ring_promotion_banner_mobile_2; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('ring_promotion_banner_mobile_2')->getClientOriginalExtension();
				$fileName_ring_promotion_banner_mobile_2 = "ring_promotion_banner_mobile_2_" . time() . '.' . $extension;
				$path = $request->file('ring_promotion_banner_mobile_2')->storeAs('public/storage/images/homeContent', $fileName_ring_promotion_banner_mobile_2,'s3');
				$ring_promotion_banner_mobile_2 = 'images/homeContent/' . $fileName_ring_promotion_banner_mobile_2;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $ring_promotion_banner_mobile_2 = $homecontant->ring_promotion_banner_mobile_2;
			}

			// ring_promotion_banner_desktop_3
			if ($request->file('ring_promotion_banner_desktop_3') != NULL) {
				$oldImagePath = $homecontant->ring_promotion_banner_desktop_3; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('ring_promotion_banner_desktop_3')->getClientOriginalExtension();
				$fileName_ring_promotion_banner_desktop_3 = "ring_promotion_banner_desktop_3_" . time() . '.' . $extension;
				$path = $request->file('ring_promotion_banner_desktop_3')->storeAs('public/storage/images/homeContent', $fileName_ring_promotion_banner_desktop_3,'s3');
				$ring_promotion_banner_desktop_3 = 'images/homeContent/' . $fileName_ring_promotion_banner_desktop_3;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $ring_promotion_banner_desktop_3 = $homecontant->ring_promotion_banner_desktop_3;
			}

			//ring_promotion_banner_mobile_3
			if ($request->file('ring_promotion_banner_mobile_3') != NULL) {
				$oldImagePath =  $homecontant->ring_promotion_banner_mobile_3; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('ring_promotion_banner_mobile_3')->getClientOriginalExtension();
				$fileName_ring_promotion_banner_mobile_3 = "ring_promotion_banner_mobile_3_" . time() . '.' . $extension;
				$path = $request->file('ring_promotion_banner_mobile_3')->storeAs('public/storage/images/homeContent', $fileName_ring_promotion_banner_mobile_3,'s3');
				$ring_promotion_banner_mobile_3 = 'images/homeContent/' . $fileName_ring_promotion_banner_mobile_3;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $ring_promotion_banner_mobile_3 = $homecontant->ring_promotion_banner_mobile_3;
			}

			// ring_promotion_banner_last
			if ($request->file('ring_promotion_banner_last') != NULL) {
				$oldImagePath =  $homecontant->ring_promotion_banner_last; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('ring_promotion_banner_last')->getClientOriginalExtension();
				$fileName_ring_promotion_banner_last = "ring_promotion_banner_last_" . time() . '.' . $extension;
				$path = $request->file('ring_promotion_banner_last')->storeAs('public/storage/images/homeContent', $fileName_ring_promotion_banner_last, 's3');
				$ring_promotion_banner_last = 'images/homeContent/' . $fileName_ring_promotion_banner_last;
                Storage::disk('s3')->setVisibility($path, 'public');
			}else{
			    $ring_promotion_banner_last = $homecontant->ring_promotion_banner_mobile_3;
			}

			$homecontant->main_banner = $main_banner;
			$homecontant->main_banner_title = $request->main_banner_title;
			$homecontant->main_banner_subtitle = $request->main_banner_subtitle;
			$homecontant->main_banner_links = $request->main_banner_links;
			$homecontant->sale_banner = $sale_banner;
			$homecontant->sale_banner_heading = $request->sale_banner_heading;
			$homecontant->sale_banner_link = $request->sale_banner_link;
			$homecontant->sale_banner_desc = $request->sale_banner_desc;
			$homecontant->sale_banner_alt = $request->sale_banner_alt;
			$homecontant->ring_promotion_banner_desktop_1 = $ring_promotion_banner_desktop_1;
			$homecontant->ring_promotion_banner_mobile_1 = $ring_promotion_banner_mobile_1;
			$homecontant->ring_promotion_banner_alt_1 = $request->ring_promotion_banner_alt_1;
			$homecontant->ring_promotion_banner_title_1 = $request->ring_promotion_banner_title_1;
			$homecontant->ring_promotion_banner_desc_1 = $request->ring_promotion_banner_desc_1;
			$homecontant->ring_promotion_banner_link_1 = $request->ring_promotion_banner_link_1;
			$homecontant->ring_promotion_banner_desktop_2 = $ring_promotion_banner_desktop_2;
			$homecontant->ring_promotion_banner_mobile_2 = $ring_promotion_banner_mobile_2;
			$homecontant->ring_promotion_banner_alt_2 = $request->ring_promotion_banner_alt_2;
			$homecontant->ring_promotion_banner_title_2 = $request->ring_promotion_banner_title_2;
			$homecontant->ring_promotion_banner_desc_2 = $request->ring_promotion_banner_desc_2;
			$homecontant->ring_promotion_banner_link_2 = $request->ring_promotion_banner_link_2;
			$homecontant->ring_promotion_banner_desktop_3 = $ring_promotion_banner_desktop_3;
			$homecontant->ring_promotion_banner_mobile_3 = $ring_promotion_banner_mobile_3;
			$homecontant->ring_promotion_banner_alt_3 = $request->ring_promotion_banner_alt_3;
			$homecontant->ring_promotion_banner_title_3 = $request->ring_promotion_banner_title_3;
			$homecontant->ring_promotion_banner_desc_3 = $request->ring_promotion_banner_desc_3;
			$homecontant->ring_promotion_banner_link_3 = $request->ring_promotion_banner_link_3;
			$homecontant->ring_promotion_banner_last = $ring_promotion_banner_last;
			$homecontant->ring_promotion_banner_alt = $request->ring_promotion_banner_alt;
			$homecontant->ring_promotion_banner_desc = $request->ring_promotion_banner_desc;
			$homecontant->save();
			return redirect()->back()->with('success', 'Data updated successfully');
		}
	}
