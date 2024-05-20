<?php
	
	namespace App\Http\Controllers\API;
	use Illuminate\Support\Facades\Hash;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Models\Banner;
	use App\Models\Cart;
	use App\Models\ProductModel;
    use App\Models\Wishlist;
    use App\Models\User;
    use App\Models\OrderModel;
    use App\Models\OrderItem;
    use Validator;
	
	class UserDashboardController extends Controller
	{
		public function index(Request $request)
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
            }else{
				$cart = $this->cartItems($request->user_id);
				$wishlist = $this->getWishlist($request->user_id);
				$output['res'] = 'success';  
				$output['msg'] = 'data retrieved successfully';
                $output['userdata'] = $this->getUserData($request->user_id);
                $output['cart'] = $cart;
				$output['wishlist'] = $wishlist;
				$output['order_history'] = $this->getOrderHistory($request->user_id);
			}
			return response()->json($output, 200);
		}

        public function getUserData($user_id)
        {
           $user =  User::find($user_id);
           return $user;
        }

        public function updateUserData(Request $request,$id)
        {
            $user  = User::find($id);
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'current_password' => 'required',
                'password' => 'required|min:8',
                'c_password' => 'required|same:password',
            ]);
            // Check if validation fails
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $output['res'] = 'error';
                $output['msg'] = $errors;
                return response()->json($output, 401);
            }
            // Check if the current password matches the user's password
            if (!Hash::check($request->current_password, $user->password)) {
                $output['res'] = 'error';
                $output['msg'] = 'Current password is incorrect.';
                return response()->json($output, 401);
            }
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->status = 'true';
            $user->password= bcrypt($request->password);     
            $user->save();
            $output['res'] = 'success';
            $output['msg'] = 'Data updated successfully.';
            $output['data'] = $user;
            return response()->json($output, 200);

        }
		
		public function cartItems($user_id)
        {
		    	$cart = Cart::where('status', 'true')
						->where('user_id',$user_id)
						->latest()
						->take(4)
						->get();
        
                $cart_collection = [];
                foreach ($cart as $cartitems) {
                    $item_data = []; 
                    $item_data['id'] = $cartitems->id;
                    
                    $item_data['active_color'] = $cartitems->ring_color;
                    $item_data['ring_price'] = $cartitems->ring_price;
                    $item_data['ring_carat'] = $cartitems->ring_carat;
                    $item_data['carat_price'] = $cartitems->carat_price;
                    $item_data['img_sku'] = $cartitems->img_sku;
                    $item_data['diamond_id'] = $cartitems->diamond_id;
                    $item_data['diamond_price'] = $cartitems->diamond_price;
                    $item_data['gemstone_id'] = $cartitems->gemstone_id;
                    $item_data['gemstone_id'] = $cartitems->gemstone_id;
                    $item_data['gemstone_price'] = $cartitems->gemstone_price;
                    $item_data['status'] = $cartitems->status;
                 

                    if (!empty($cartitems->ring_id)) {
                        // fetch ring data here 
                        $ring_data = ProductModel::where('id', $cartitems->ring_id)->first();
                        $item_data['ring'] = $ring_data; 
                    }else
                    {
                        $item_data['ring'] = [];
                    }

                    if (!empty($cartitems->diamond_id)) {
                        // fetch diamond data here 
                        $diamond_data = ''; 
    
                        $url = "https://apiservices.vdbapp.com/v2/diamonds?type=Diamond&stock_num=$cartitems->diamond_id";
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
                        $diamond_data = $resp->response->body->diamonds;
                        $item_data['diamond'] = $diamond_data; 

                    }else
                    {
                        $item_data['diamond'] = []; 
                    }

                    if (!empty($cartitems->gemstone_id) || !is_null($cartitems->gemstone_id)) {
                        // fetch gemstone data here 
                        $gemstone_data = '';

                        ########################      
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
                        #########################
                    }
                    else
                    {
                        $item_data['gemstone'] = []; 
                    }
                    $cart_collection[] = $item_data;
                }
				return $cart_collection;        
        }

        public function getWishlist($user_id)
        {
            $cart = Wishlist::where('status', 'true')
            ->where('user_id',$user_id)
            ->latest()
            ->take(4)
            ->get();

            $cart_collection = [];
            foreach ($cart as $cartitems) {
                $item_data = []; 
                $item_data['id'] = $cartitems->id;
                $item_data['product_type'] = $cartitems->product_type;
                $item_data['active_color'] = $cartitems->ring_color;
                $item_data['ring_price'] = $cartitems->ring_price;
                $item_data['ring_carat'] = $cartitems->ring_carat;
                $item_data['carat_price'] = $cartitems->carat_price;
                $item_data['img_sku'] = $cartitems->img_sku;
                $item_data['diamond_id'] = $cartitems->diamond_id;
                $item_data['diamond_price'] = $cartitems->diamond_price;
                $item_data['gemstone_id'] = $cartitems->gemstone_id;
                $item_data['gemstone_id'] = $cartitems->gemstone_id;
                $item_data['gemstone_price'] = $cartitems->gemstone_price;
                $item_data['status'] = $cartitems->status;
            

                if (!empty($cartitems->ring_id)) {
                    // fetch ring data here 
                    $ring_data = ProductModel::where('id', $cartitems->ring_id)->first();
                    $item_data['ring'] = $ring_data; 
                }else
                {
                    $item_data['ring'] = [];
                }

                if (!empty($cartitems->diamond_id)) {
                    // fetch diamond data here 
                    $diamond_data = ''; 

                    $url = "https://apiservices.vdbapp.com/v2/diamonds?type=Diamond&stock_num=$cartitems->diamond_id";
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
                    $diamond_data = $resp->response->body->diamonds;
                    $item_data['diamond'] = $diamond_data; 

                }else
                {
                    $item_data['diamond'] = []; 
                }

                if (!empty($cartitems->gemstone_id) || !is_null($cartitems->gemstone_id)) {
                    // fetch gemstone data here 
                    $gemstone_data = '';
                    ########################      
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
                    #########################
                }
                else
                {
                    $item_data['gemstone'] = []; 
                }
                $cart_collection[] = $item_data;
            }
            return $cart_collection;  
        }

        public function getOrderHistory($user_id)
        {
            $orders = OrderModel::orderBy('id','desc')
            ->where('user_id',$user_id)
            ->latest()
            ->take(1)
            ->get();
            return $orders;
        }
	}
