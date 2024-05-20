<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ProductModel;
use Validator;

class CartController extends Controller
{
	public function index(Request $request)
	{
		$rules = [
			'user_id' => 'required',
			// 'product_type' => 'required',
			// 'ring_id' => 'required_without_all:diamond_id,gemstone_id',
			// 'ring_type' => 'required_with:ring_id|required_without_all:diamond_id,gemstone_id',
			// 'diamond_id' => 'required_without_all:ring_id,gemstone_id',
			// 'gemstone_id' => 'required_without_all:ring_id,diamond_id',
			// 'ring_color' => 'required_with:ring_id',
			// 'img_sku' => 'required_with:ring_id',
			'ring_price' => 'required_with:ring_id',
		];
		$messages = [
			'user_id.required' => 'User id is required.',
			// 'product_type.required' => 'Product type id is required.',
			// 'ring_id.required_without_all' => 'Ring id is required if no diamond id or gemstone id is provided.',
			// 'diamond_id.required_without_all' => 'Diamond id is required if no ring id or gemstone id is provided.',
			// 'ring_type.required_without_all' => 'Ring id is required',
			// 'gemstone_id.required_without_all' => 'Gemstone id is required if no ring id or diamond id is provided.',
			// 'ring_color.required_with' => 'Ring color is required when ring id is provided.',
			// 'img_sku.required_with' => 'Image SKU is required when ring id is provided.',
			'ring_price.required_with' => 'Ring price is required when ring id is provided.',
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();
			$output['res'] = 'error';
			$output['msg'] = $errors;
			return response()->json($output, 401);
		} else {
			$metalColorval = $request->metalColor;
			switch ($metalColorval) {
				case "18K WHITE GOLD":
					$metalColor = 'White';
					break;
				case "18K YELLOW GOLD":
					$metalColor = 'Yellow';
					break;
				case "18K ROSE GOLD":
					$metalColor = 'Pink';
					break;
				default:
					$metalColor = $metalColorval;
					break;
			}

			$cart = new Cart;
			$cart->user_id = $request->user_id;
			$cart->ring_id = $request->ring_id;
			$cart->ring_size = $request->ring_size;
			$cart->ring_type = $request->ring_type;
			$cart->ring_color = $request->ring_color;
			$cart->ring_price = $request->ring_price;
			$cart->metalType = $request->metalType;
			$cart->metalColor = $metalColor;
			$cart->img_sku = $request->img_sku;
			$cart->diamond_id = $request->diamond_id;
			$cart->diamond_stock_no = $request->diamond_stock_no;
			$cart->diamond_price = $request->diamond_price;
			$cart->gemstone_id = $request->gemstone_id;
			$cart->gemstone_stock_no = $request->gemstone_stock_no;
			$cart->gemstone_price = $request->gemstone_price;
			$cart->status = 'true';
			$cart->save();
			$output['res'] = 'success';
			$output['msg'] = 'product added in cart';
			$output['data'] = Cart::latest()->first();
			return response()->json($output, 200);
		}
	}

	public function cartItems(Request $request)
	{
		$rules = [
			'user_id' => 'required',
		];
		$messages = [
			'user_id.required' => 'User id is required.',

		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();
			$output['res'] = 'error';
			$output['msg'] = $errors;
			return response()->json($output, 401);
		} else {
			$cart = Cart::orderBy('id', 'desc')->where('user_id', $request->user_id)->where('status', 'true')->get();
			$cart_collection = [];
			foreach ($cart as $cartitems) {
				$item_data = [];
				$item_data['id'] = $cartitems->id;
				$item_data['user_id'] = $cartitems->user_id;
				$item_data['ring_id'] = $cartitems->ring_id;
				$item_data['ring_size'] = $cartitems->ring_size;
				$item_data['ring_type'] = $cartitems->ring_type;
				$item_data['active_color'] = $cartitems->ring_color;
				$item_data['metalType'] = $cartitems->metalType;
				$item_data['metalColor'] = $cartitems->metalColor;
				$item_data['ring_price'] = $cartitems->ring_price;
				$item_data['img_sku'] = $cartitems->img_sku;
				$item_data['diamond_id'] = $cartitems->diamond_id;
				$item_data['diamond_stock_no'] = $cartitems->diamond_stock_no;
				$item_data['diamond_price'] = $cartitems->diamond_price;
				$item_data['gemstone_id'] = $cartitems->gemstone_id;
				$item_data['gemstone_stock_no'] = $cartitems->gemstone_stock_no;
				$item_data['gemstone_price'] = $cartitems->gemstone_price;

				if (!empty($cartitems->ring_id)) {
					// fetch ring data here 
					$ring_data = ProductModel::where('id', $cartitems->ring_id)->first();
					$item_data['ring'] = $ring_data;
				} else {
					$item_data['ring'] = [];
				}

				if (!empty($cartitems->diamond_id)) {
					// fetch diamond data here 
					$diamond_data = '';
					$encodedDiamondId = urlencode($cartitems->diamond_id);
					$url = "https://apiservices.vdbapp.com/v2/diamonds?type=Diamond&stock_num=$encodedDiamondId";
					$curl = curl_init();

					curl_setopt_array($curl, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'GET',
						CURLOPT_HTTPHEADER => array(
							'Authorization: Token token=iltz_Ie1tN0qm-ANqF7X6SRjwyhmMtzZsmqvyWOZ83I, api_key=_eTAh9su9_0cnehpDpqM9xA'
						),
					));

					$response = curl_exec($curl);

					curl_close($curl);
					$resp = json_decode($response);

					if ($resp === null && json_last_error() !== JSON_ERROR_NONE) {
						$item_data['diamond'] = [];
					} else {
						// JSON decoding succeeded
						if (isset($resp->response->body->diamonds)) {
							// Extract diamond data
							$diamond_data = $resp->response->body->diamonds;
							$item_data['diamond'] = $diamond_data;
						} else {
							// Handle missing diamonds data
							$item_data['diamond'] = [];
						}
					}

					// $diamond_data = $resp->response->body->diamonds;
					// $item_data['diamond'] = $diamond_data; 

				} else {
					$item_data['diamond'] = [];
				}

				if (!empty($cartitems->gemstone_id) || !is_null($cartitems->gemstone_id)) {
					// fetch gemstone data here 
					$gemstone_data = '';
					$url = "https://apiservices.vdbapp.com/v2/gemstones?stock_num=$cartitems->gemstone_id";
					$curl = curl_init();

					curl_setopt_array($curl, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'GET',
						CURLOPT_HTTPHEADER => array(
							'Authorization: Token token=iltz_Ie1tN0qm-ANqF7X6SRjwyhmMtzZsmqvyWOZ83I, api_key=_eTAh9su9_0cnehpDpqM9xA'
						),
					));
					$response = curl_exec($curl);
					curl_close($curl);
					$resp = json_decode($response);
					$gemstone_data = $resp->response->body->gemstones;
					$item_data['gemstone'] = $gemstone_data;
				} else {
					$item_data['gemstone'] = [];
				}
				$cart_collection[] = $item_data;
			}
			return response()->json($cart_collection, 200);
		}
	}

	public function removeCartItem($id)
	{
		$data =  Cart::find($id);
		if ($data) {
			$cartItem =  Cart::where('id', $id)->delete();
			if ($cartItem) {
				$output['res'] = 'success';
				$output['msg'] = 'product removed from cart';
				$output['data'] = '';
				return response()->json($output, 200);
			} else {
				$output['res'] = 'error';
				$output['msg'] = 'something went wrong while deleting';
				$output['data'] = '';
				return response()->json($output, 201);
			}
		} else {
			$output['res'] = 'error';
			$output['msg'] = 'Invalid ID';
			$output['data'] = '';
			return response()->json($output, 201);
		}
	}

	public function updateCart(Request $request)
	{
		$rules = [
			'cart_id' => 'required',
			'ring_size' => 'required',
		];
		$messages = [
			'cart_id.required' => 'Cart id is required.',
			'ring_size.required' => 'Ring size is required.',
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();
			$output['res'] = 'error';
			$output['msg'] = $errors;
			return response()->json($output, 401);
		} else {
			$obj = Cart::find($request->cart_id);
			if ($obj) {
				$obj->ring_size = $request->ring_size;
				$obj->save();
				$output['res'] = 'success';
				$output['msg'] = 'Ring size updated.';
				$output['data'] = ['ring_size' => $obj->ring_size];
				return response()->json($output, 200);
			}
		}
	}
}
