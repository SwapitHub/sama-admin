<?php
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	/*
		|--------------------------------------------------------------------------
		| API Routes
		|--------------------------------------------------------------------------
		|
		| Here is where you can register API routes for your application. These
		| routes are loaded by the RouteServiceProvider within a group which
		| is assigned the "api" middleware group. Enjoy building your API!
		|
	*/
	Route::get('/csrf-token', function () {
		return response()->json(['csrf_token' => csrf_token()]);
	});
	
	Route::prefix('v1')->group(function () {
		Route::any('newsletter',[App\Http\Controllers\API\NewsletterController::class,'index']);
		Route::get('token', [App\Http\Controllers\API\SiteinfoController::class, 'getCsrfToken']);
		Route::post('user-registration', [App\Http\Controllers\API\RegisterController::class, 'registerUser']);
		Route::any('login', [App\Http\Controllers\API\RegisterController::class, 'login']);
		Route::get('diamondshape',[App\Http\Controllers\API\DiamondController::class,'diamondShape']);
		Route::post('contact',[App\Http\Controllers\API\FaqController::class,'contactUs']);
		Route::get('languages',[App\Http\Controllers\API\LocalizationController::class,'index']);
		Route::get('banners',[App\Http\Controllers\API\BannerController::class,'index']);
		Route::get('siteinfo',[App\Http\Controllers\API\SiteinfoController::class,'index']);
		Route::get('menu',[App\Http\Controllers\API\MenuController::class,'index']);
		Route::get('get-menu/{slug}',[App\Http\Controllers\API\MenuController::class,'getMenuName']);
		Route::get('rings',[App\Http\Controllers\API\MenuController::class,'rings']);
		Route::get('products',[App\Http\Controllers\API\ProductController::class,'index']);
		Route::get('product/{entity_id}',[App\Http\Controllers\API\ProductController::class,'productDetails']);
		Route::get('faq',[App\Http\Controllers\API\FaqController::class,'index']);
		Route::get('homecontent',[App\Http\Controllers\API\SiteinfoController::class,'homeContent']);
		Route::get('metalcolor',[App\Http\Controllers\API\SiteinfoController::class,'metalColor']);
		Route::post('findimage',[App\Http\Controllers\API\ProductController::class,'getImageForListing']);
		Route::any('getactiveproduct',[App\Http\Controllers\API\ProductController::class,'getActiveProductDetails']);
		Route::get('product-style',[App\Http\Controllers\API\ProductController::class,'productStyle']);
		Route::any('cart',[App\Http\Controllers\API\CartController::class,'index']);
		Route::get('homepage-data',[App\Http\Controllers\API\SiteinfoController::class,'otherHomeData']);
		Route::get('footer-pages',[App\Http\Controllers\API\PageController::class,'index']);
		Route::get('contact-faq',[App\Http\Controllers\API\PageController::class,'contactFaq']);
		Route::get('diamonds',[App\Http\Controllers\API\DiamondController::class,'getDiaminds']);
		Route::any('getcart-items',[App\Http\Controllers\API\CartController::class,'cartItems']);
		Route::get('remove-cartitem/{id}',[App\Http\Controllers\API\CartController::class,'removeCartItem']);
		Route::get('update-ring-size',[App\Http\Controllers\API\CartController::class,'updateCart']);
		Route::any('user-account',[App\Http\Controllers\API\UserDashboardController::class,'index']);
		Route::any('add_to_wishlist',[App\Http\Controllers\API\WishlistController::class,'index']);
		Route::any('wishlist-items',[App\Http\Controllers\API\WishlistController::class,'getWishlistItem']);
		Route::any('update_preferences/{id}',[App\Http\Controllers\API\UserDashboardController::class,'updateUserData']);
		Route::get('remove_wishlist_item/{id}',[App\Http\Controllers\API\WishlistController::class,'deleteItem']);
		Route::get('check_product_in_wishlist',[App\Http\Controllers\API\WishlistController::class,'checkProductInWishlist']);
		Route::get('search',[App\Http\Controllers\API\ProductController::class,'globleSearch']);
		Route::get('search-suggestion',[App\Http\Controllers\API\ProductController::class,'searhSuggestion']);
		Route::get('gemstone-attributes',[App\Http\Controllers\API\GemstoneAttributeController::class,'index']);
		Route::any('save-users-address',[App\Http\Controllers\API\AddressController::class,'index']);
		Route::any('get-users-address',[App\Http\Controllers\API\AddressController::class,'getUserAddress']);
		Route::get('get_product_price',[App\Http\Controllers\API\ProductController::class,'fetchProductPriceing']);
		Route::any('checkout',[App\Http\Controllers\API\CheckOutController::class,'checkout']);
		Route::get('order-history',[App\Http\Controllers\API\OrdersController::class,'index']);
		Route::get('order-detail',[App\Http\Controllers\API\OrdersController::class,'historyDetail']);
		
	});
	
	// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
		// return $request->user();
	// });
