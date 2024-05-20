<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
/*
		|--------------------------------------------------------------------------
		| Web Routes
		|--------------------------------------------------------------------------
		|
		| Here is where you can register web routes for your application. These
		| routes are loaded by the RouteServiceProvider within a group which
		| contains the "web" middleware group. Now create something great!
		|
	*/

Route::get('/test', function () {
	// Artisan::call('make:model BlogModel');
	// return 'OK';
	//phpinfo();
	// $img_url = 's3://s3-sama/decorators.png';
	Storage::put('test1.txt', 'test again');
	$contents = Storage::disk('s3')->get('test1.txt');
	var_dump($contents);

	// return Storage::disk($disk)->url($uploadedPath);
});
Route::get('/', function () {
	return view('admin.login');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['prefix' => 'admin'], function() {
Route::group(['middleware' => 'admin.guest'], function () {
	Route::view('/login', 'admin.login')->name('admin.login');
	Route::post('/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'authenticate'])->name('admin.auth');
});

// Route::group(['middleware' => 'admin.auth'], function(){
Route::group(['middleware' => ['admin.auth', 'checkUserAllowed']], function () {
	Route::get('/logout', [App\Http\Controllers\Auth\AdminAuthController::class, 'logout'])->name('admin.logout');
	Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
	Route::get('/profile', [App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
	Route::post('/profile', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.updateProfile');
	Route::post('/change_password', [App\Http\Controllers\AdminController::class, 'changePassword'])->name('admin.changePassword');
	Route::post('/update_icon', [App\Http\Controllers\AdminController::class, 'updateIcon'])->name('admin.upload_icon');
	Route::get('/siteinfo', [App\Http\Controllers\SiteinfoController::class, 'index'])->name('admin.siteinfo');
	Route::post('/siteinfo', [App\Http\Controllers\SiteinfoController::class, 'update_siteinfo'])->name('admin.update_siteinfo');
	Route::post('/updatesite_urls', [App\Http\Controllers\SiteinfoController::class, 'updatesite_urls'])->name('admin.updatesite_urls');
	Route::get('/addbanner', [App\Http\Controllers\BannerController::class, 'addbanner'])->name('admin.addbanner');
	Route::post('/addbanner', [App\Http\Controllers\BannerController::class, 'postAddBanner'])->name('admin.createbanner');
	Route::get('/bannerlist', [App\Http\Controllers\BannerController::class, 'index'])->name('admin.bannerlist');
	Route::get('/deletebanner/{id}', [App\Http\Controllers\BannerController::class, 'deleteBanner'])->name('admin.deletebanner');
	Route::get('/editbanner/{id}', [App\Http\Controllers\BannerController::class, 'editBanner'])->name('admin.getedit');
	Route::post('/updatebanner', [App\Http\Controllers\BannerController::class, 'postEditBanner'])->name('admin.updatebanner');
	Route::get('/languages', [App\Http\Controllers\LanguageController::class, 'index'])->name('admin.language');
	Route::get('/addlang', [App\Http\Controllers\LanguageController::class, 'addLangView'])->name('admin.langview');
	Route::post('/addlang', [App\Http\Controllers\LanguageController::class, 'addLanguage'])->name('admin.addlang');
	Route::get('/editlang/{id}', [App\Http\Controllers\LanguageController::class, 'editLang'])->name('admin.editlang');
	Route::post('/editlang', [App\Http\Controllers\LanguageController::class, 'postEditLang'])->name('admin.updatelang');
	Route::get('/deletelang/{id}', [App\Http\Controllers\LanguageController::class, 'deleteLang'])->name('admin.deletelang');
	Route::get('/currency', [App\Http\Controllers\CurrencyController::class, 'index'])->name('admin.currency');
	Route::get('/addcurrency', [App\Http\Controllers\CurrencyController::class, 'addCurrencyView'])->name('admin.currencyview');
	Route::post('/addcurrency', [App\Http\Controllers\CurrencyController::class, 'addCurrency'])->name('admin.addcurrency');
	Route::get('/editcurrency/{id}', [App\Http\Controllers\CurrencyController::class, 'editCurrency'])->name('admin.editcurrency');
	Route::post('/editcurrency', [App\Http\Controllers\CurrencyController::class, 'postEditCurrency'])->name('admin.updatecurrency');
	Route::get('/deletecurrency/{id}', [App\Http\Controllers\CurrencyController::class, 'deleteCurrency'])->name('admin.deletecurrency');
	Route::get('/cms_category', [App\Http\Controllers\CmsController::class, 'cmsCategory'])->name('admin.cmscategory');
	Route::get('/cms_addcategory', [App\Http\Controllers\CmsController::class, 'addCmsCategory'])->name('admin.addcmscategory');
	Route::post('/cms_addcategory', [App\Http\Controllers\CmsController::class, 'postCmsCategory'])->name('admin.postcmscategory');
	Route::get('/cms_editcategory/{id}', [App\Http\Controllers\CmsController::class, 'editCmsCategory'])->name('admin.editcmscategory');
	Route::post('/cms_updatecategory', [App\Http\Controllers\CmsController::class, 'updateCmsCategory'])->name('admin.updatecmscategory');
	Route::get('/cms_deletecategory/{id}', [App\Http\Controllers\CmsController::class, 'deleteCmsCategory'])->name('admin.deletecmscategory');
	Route::get('/cms_content', [App\Http\Controllers\CmsController::class, 'index'])->name('admin.cmscontent');
	Route::get('/cms_addcontent', [App\Http\Controllers\CmsController::class, 'addcmsContent'])->name('admin.addcmscontent');
	Route::post('/cms_addcontent', [App\Http\Controllers\CmsController::class, 'postAddCmsContent'])->name('admin.postaddcmscontent');
	Route::get('/cms_editcontent/{id}', [App\Http\Controllers\CmsController::class, 'editCmsContent'])->name('admin.editcmscontent');
	Route::post('/cms_editcontent', [App\Http\Controllers\CmsController::class, 'updateCmsContent'])->name('admin.updatecmscontent');
	Route::get('/cms_deletecontent/{id}', [App\Http\Controllers\CmsController::class, 'deleteCmsContent']);
	Route::get('/emailsmtp', [App\Http\Controllers\SmtpController::class, 'index'])->name('admin.emailsmtp');
	Route::post('/emailsmtp', [App\Http\Controllers\SmtpController::class, 'updateSmtp'])->name('admin.updatesmtp');
	Route::get('/menus', [App\Http\Controllers\MenuController::class, 'index'])->name('admin.menus');
	Route::get('/createmenu', [App\Http\Controllers\MenuController::class, 'createMenuView'])->name('admin.createmenu');
	Route::post('/createmenu', [App\Http\Controllers\MenuController::class, 'postCreateMenu'])->name('admin.postcreatemenu');
	Route::get('/editmenu/{id}', [App\Http\Controllers\MenuController::class, 'editMenu'])->name('admin.editmenu');
	Route::post('/editmenu', [App\Http\Controllers\MenuController::class, 'postEditMenu'])->name('admin.updatemenu');
	Route::get('/deletemenu/{id}', [App\Http\Controllers\MenuController::class, 'deleteMenu'])->name('admin.deletemenu');
	Route::get('/addcategory', [App\Http\Controllers\CategoryController::class, 'addCatView'])->name('admin.addcategory');
	Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('admin.categories');
	Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'postCategory'])->name('admin.addcategories');
	Route::get('/getselectedcategory/{menuid}/{selected}', [App\Http\Controllers\CategoryController::class, 'getSelectedCategory']);
	Route::post('/getselectedcategories/{menuid}', [App\Http\Controllers\CategoryController::class, 'getSelectedCategories']);
	Route::get('/getcategories/{id}', [App\Http\Controllers\CategoryController::class, 'getCategory']);
	Route::get('/editcategory/{id}', [App\Http\Controllers\CategoryController::class, 'editCategory'])->name('admin.editcategory');
	Route::post('/editcategory', [App\Http\Controllers\CategoryController::class, 'updateCategory'])->name('admin.updatecategory');
	Route::get('/deletecategory/{id}', [App\Http\Controllers\CategoryController::class, 'deleteCategory'])->name('admin.delcategory');
	Route::post('/getsubcategories/{menuid}', [App\Http\Controllers\SubcategoryController::class, 'getSubcategories']);
	Route::get('/subcategories', [App\Http\Controllers\SubcategoryController::class, 'index'])->name('admin.subcategories');
	Route::get('/createcategory', [App\Http\Controllers\SubcategoryController::class, 'createSubcategoryView'])->name('admin.creatsubcategory');
	Route::post('/createcategory', [App\Http\Controllers\SubcategoryController::class, 'addSubcategory'])->name('admin.addsubcategory');
	Route::get('/deletesubcat/{id}', [App\Http\Controllers\SubcategoryController::class, 'deleteSubcategory'])->name('admin.deletesubcat');
	Route::get('/editsubcat/{id}', [App\Http\Controllers\SubcategoryController::class, 'editSubcategory'])->name('admin.editsubcat');
	Route::post('/editsubcat', [App\Http\Controllers\SubcategoryController::class, 'updateSubcategory'])->name('admin.updatesubcat');
	Route::get('/diamondshape', [App\Http\Controllers\DiamondController::class, 'index'])->name('admin.diamondshape');
	Route::get('/addshape', [App\Http\Controllers\DiamondController::class, 'shapeAddView'])->name('admin.addshape');
	Route::post('/addshape', [App\Http\Controllers\DiamondController::class, 'shapeAdd'])->name('admin.postaddshape');
	Route::get('/editshape/{id}', [App\Http\Controllers\DiamondController::class, 'editShapeView'])->name('admin.editshape');
	Route::post('/editshape', [App\Http\Controllers\DiamondController::class, 'editShape'])->name('admin.updateshape');
	Route::get('/deleteshape/{id}', [App\Http\Controllers\DiamondController::class, 'deleteShape']);
	Route::get('/ringstyle', [App\Http\Controllers\RingController::class, 'index'])->name('admin.ringstyle');
	Route::get('/addringstyle', [App\Http\Controllers\RingController::class, 'addRingStyle'])->name('admin.addringstyle');
	Route::post('/addringstyle', [App\Http\Controllers\RingController::class, 'postAddRingstyle'])->name('admin.postaddringstyle');
	Route::get('/editringstyle/{id}', [App\Http\Controllers\RingController::class, 'editRingStyleView'])->name('admin.editringstyle');
	Route::post('/editringstyle', [App\Http\Controllers\RingController::class, 'PosteditRingStyle'])->name('admin.updatestyle');
	Route::get('/deleteringstyle/{id}', [App\Http\Controllers\RingController::class, 'deleteRingStyle']);
	Route::get('/ringmetallist', [App\Http\Controllers\RingMetalController::class, 'index'])->name('admin.ringmetal');
	Route::get('/ringmetal', [App\Http\Controllers\RingMetalController::class, 'ringmetal'])->name('admin.addringmetal');
	Route::post('/ringmetal', [App\Http\Controllers\RingMetalController::class, 'createMetal'])->name('admin.createringmetal');
	Route::get('/ringmetal/edit/{id}', [App\Http\Controllers\RingMetalController::class, 'editMetal'])->name('admin.editringmetal');
	Route::post('/updateringmetal/{id}', [App\Http\Controllers\RingMetalController::class, 'postEdit'])->name('admin.updatemetal');
	Route::get('/deletemetal/{id}', [App\Http\Controllers\RingMetalController::class, 'deleteMetal']);
	Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('admin.customer');
	Route::get('/customer/add', [App\Http\Controllers\CustomerController::class, 'create'])->name('admin.customeradd');
	Route::post('/customer/add', [App\Http\Controllers\CustomerController::class, 'postCreate'])->name('admin.addcustomer');
	Route::get('/customer/edit/{id}', [App\Http\Controllers\CustomerController::class, 'editCustomer'])->name('admin.editcustomer');
	Route::get('/customer/view/{id}', [App\Http\Controllers\CustomerController::class, 'viewCustomer'])->name('admin.customer.view');
	Route::post('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'postEdit'])->name('admin.updatecustomer');
	Route::get('/deletecustomer/{id}', [App\Http\Controllers\CustomerController::class, 'deleteCustomer']);

	Route::get('/contact', [App\Http\Controllers\CustomerController::class, 'contact'])->name('admin.customer.messagelist');
	// Route::get('/customer/add',[App\Http\Controllers\CustomerController::class, 'create'])->name('admin.customeradd');
	// Route::post('/customer/add',[App\Http\Controllers\CustomerController::class, 'postCreate'])->name('admin.addcustomer');
	// Route::get('/customer/edit/{id}',[App\Http\Controllers\CustomerController::class, 'editCustomer'])->name('admin.editcustomer');
	// Route::post('/customer/{id}',[App\Http\Controllers\CustomerController::class, 'postEdit'])->name('admin.updatecustomer');
	Route::get('/deletecustomermsg/{id}', [App\Http\Controllers\CustomerController::class, 'deleteCustomerMsg']);

	Route::get('/country/', [App\Http\Controllers\CountryController::class, 'index'])->name('admin.country');
	Route::get('/country/add', [App\Http\Controllers\CountryController::class, 'create'])->name('admin.countryadd');
	Route::post('/country/add', [App\Http\Controllers\CountryController::class, 'postCreate'])->name('admin.addcountry');
	Route::get('/country/edit/{id}', [App\Http\Controllers\CountryController::class, 'editCustomer'])->name('admin.editcountry');
	Route::post('/country/{id}', [App\Http\Controllers\CountryController::class, 'postEdit'])->name('admin.updatecountry');
	Route::get('/deletecountry/{id}', [App\Http\Controllers\CountryController::class, 'deleteCountry']);
	Route::get('/ringprong/', [App\Http\Controllers\RingProngController::class, 'index'])->name('admin.ringprong');
	Route::get('/ringprong/add', [App\Http\Controllers\RingProngController::class, 'createProng'])->name('admin.addringprong');
	Route::post('/ringprong/add', [App\Http\Controllers\RingProngController::class, 'postCreateProng'])->name('admin.ringprongadd');
	Route::get('/ringprong/edit/{id}', [App\Http\Controllers\RingProngController::class, 'editProng'])->name('admin.editringprong');
	Route::post('/ringprong/update/{id}', [App\Http\Controllers\RingProngController::class, 'postEditProng'])->name('admin.updateringprong');
	Route::get('/deleteprong/{id}', [App\Http\Controllers\RingProngController::class, 'deleteProng']);
	Route::get('/carat', [App\Http\Controllers\CaratController::class, 'index'])->name('admin.carat');
	Route::get('/carat/add', [App\Http\Controllers\CaratController::class, 'addCarat'])->name('admin.addcarat');
	Route::post('/carat/add', [App\Http\Controllers\CaratController::class, 'postAddCarat'])->name('admin.caratadd');
	Route::get('/carat/edit/{id}', [App\Http\Controllers\CaratController::class, 'editCarat'])->name('admin.editcarat');
	Route::post('/carat/update/{id}', [App\Http\Controllers\CaratController::class, 'PostEditCarat'])->name('admin.updatecarat');
	Route::get('/carat/delete/{id}', [App\Http\Controllers\CaratController::class, 'deleteCarat'])->name('admin.updatecarat');

	Route::get('/diamondcut', [App\Http\Controllers\DiamonCutController::class, 'index'])->name('admin.cut');
	Route::get('/diamondcut/add', [App\Http\Controllers\DiamonCutController::class, 'addCut'])->name('admin.addcut');
	Route::post('/diamondcut/add', [App\Http\Controllers\DiamonCutController::class, 'postAddCut'])->name('admin.cutadd');
	Route::get('/diamondcut/edit/{id}', [App\Http\Controllers\DiamonCutController::class, 'editCut'])->name('admin.editcut');
	Route::post('/diamondcut/update/{id}', [App\Http\Controllers\DiamonCutController::class, 'PostEditCut'])->name('admin.updatecut');
	Route::get('/diamondcut/delete/{id}', [App\Http\Controllers\DiamonCutController::class, 'deleteCut']);

	Route::get('/diamondcolor', [App\Http\Controllers\DiamondColorController::class, 'index'])->name('admin.diamondcolor');
	Route::get('/diamondcolor/add', [App\Http\Controllers\DiamondColorController::class, 'addColor'])->name('admin.adddiamondcolor');
	Route::post('/diamondcolor/add', [App\Http\Controllers\DiamondColorController::class, 'postAddColor'])->name('admin.diamondcoloradd');
	Route::get('/diamondcolor/edit/{id}', [App\Http\Controllers\DiamondColorController::class, 'editColor'])->name('admin.editdiamondcolor');
	Route::post('/diamondcolor/update/{id}', [App\Http\Controllers\DiamondColorController::class, 'PostEditColor'])->name('admin.updatediamondcolor');
	Route::get('/diamondcolor/delete/{id}', [App\Http\Controllers\DiamondColorController::class, 'deleteColor']);

	Route::get('/diamondclarity', [App\Http\Controllers\ClarityController::class, 'index'])->name('admin.diamondclarity');
	Route::get('/diamondclarity/add', [App\Http\Controllers\ClarityController::class, 'addClarity'])->name('admin.adddiamondclarity');
	Route::post('/diamondclarity/add', [App\Http\Controllers\ClarityController::class, 'postAddClarity'])->name('admin.diamondclarityadd');
	Route::get('/diamondclarity/edit/{id}', [App\Http\Controllers\ClarityController::class, 'editClarity'])->name('admin.editdiamondclarity');
	Route::post('/diamondclarity/update/{id}', [App\Http\Controllers\ClarityController::class, 'PostEditClarity'])->name('admin.updatediamondclarity');
	Route::get('/diamondclarity/delete/{id}', [App\Http\Controllers\ClarityController::class, 'deleteClarity']);

	Route::get('/diamond', [App\Http\Controllers\DiamondController::class, 'diamondList'])->name('admin.diamond');
	Route::get('/faq/categories', [App\Http\Controllers\FaqController::class, 'categories'])->name('admin.faqcategories');
	Route::get('/faq/categories/add', [App\Http\Controllers\FaqController::class, 'addCategory'])->name('admin.addfaqcategories');
	Route::post('/faq/categories/add', [App\Http\Controllers\FaqController::class, 'postAddCategory'])->name('admin.postaddfaqcategories');
	Route::get('/faq/categories/edit/{id}', [App\Http\Controllers\FaqController::class, 'editCategory'])->name('admin.editfaqcategories');
	Route::post('/faq/categories/update/{id}', [App\Http\Controllers\FaqController::class, 'updateCategory'])->name('admin.updatefaqcategories');
	Route::get('/faq/categories/delete/{id}', [App\Http\Controllers\FaqController::class, 'deleteFaqCat']);

	Route::get('/faqs', [App\Http\Controllers\FaqController::class, 'index'])->name('admin.faqs');
	Route::get('/faq/add', [App\Http\Controllers\FaqController::class, 'create'])->name('admin.addfaq');
	Route::post('/faq/add', [App\Http\Controllers\FaqController::class, 'postAddFaq'])->name('admin.postaddfaq');
	Route::get('/faq/edit/{id}', [App\Http\Controllers\FaqController::class, 'editFaq'])->name('admin.editfaq');
	Route::post('/faq/update/{id}', [App\Http\Controllers\FaqController::class, 'updateFaq'])->name('admin.updatefaq');
	Route::get('/faq/delete/{id}', [App\Http\Controllers\FaqController::class, 'deleteFaq']);
	Route::get('/product-list', [App\Http\Controllers\ProductController::class, 'index'])->name('admin.product.list');
	Route::get('/db-product-list', [App\Http\Controllers\ProductController::class, 'dbProduct'])->name('admin.product.dblist');
	Route::get('/db-product-list/edit/{id}', [App\Http\Controllers\ProductController::class, 'editProduct'])->name('admin.product.edit');
	Route::post('/db-product-list/edit/{id}', [App\Http\Controllers\ProductController::class, 'postUpdateProduct'])->name('admin.product.update');
	Route::get('/db-product-list/delete/{id}', [App\Http\Controllers\ProductController::class, 'deleteProduct'])->name('admin.product.delete');
	Route::post('/product/import', [App\Http\Controllers\ProductController::class, 'importProducts'])->name('admin.product.import');
	Route::get('/product/export', [App\Http\Controllers\ProductController::class, 'exportProduct'])->name('admin.product.export');
	Route::post('/product/create', [App\Http\Controllers\ProductController::class, 'productCreate'])->name('admin.product.create');
	Route::post('/product/configurable', [App\Http\Controllers\ProductController::class, 'addConfigurableProduct'])->name('admin.product.configurable');


	Route::get('/blog/category', [App\Http\Controllers\BlogController::class, 'blogCategory'])->name('admin.blog.cat');
	Route::post('/blog/category', [App\Http\Controllers\BlogController::class, 'postBlogCategory'])->name('admin.blog.cat');
	Route::get('/blog/category/list', [App\Http\Controllers\BlogController::class, 'blogCategoryList'])->name('admin.blog.catlist');
	Route::get('/blog/category/edit/{id}', [App\Http\Controllers\BlogController::class, 'editBlogCategory'])->name('admin.blog.editcat');
	Route::post('/blog/category/update/{id}', [App\Http\Controllers\BlogController::class, 'updateBlogCategory'])->name('admin.blog.updatecat');

	Route::get('/blog/type', [App\Http\Controllers\BlogController::class, 'blogTypeList'])->name('admin.blogtype.list');
	Route::get('/blog/type/add', [App\Http\Controllers\BlogController::class, 'addBlogType'])->name('admin.blogtype.add');
	Route::post('/blog/type/add', [App\Http\Controllers\BlogController::class, 'postAddBlogType'])->name('admin.blogtype.postadd');
	Route::get('/blog/type/edit/{id}', [App\Http\Controllers\BlogController::class, 'editBlogType'])->name('admin.blogtype.edit');
	Route::post('/blog/type/edit/{id}', [App\Http\Controllers\BlogController::class, 'postEditBlogType'])->name('admin.blogtype.update');

	Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('admin.blog');
	Route::get('/blog/add', [App\Http\Controllers\BlogController::class, 'addBlog'])->name('admin.blog.add');
	Route::post('/blog/add', [App\Http\Controllers\BlogController::class, 'postAddBlog'])->name('admin.blog.postadd');
	Route::get('/blog/edit/{id}', [App\Http\Controllers\BlogController::class, 'editBlog'])->name('admin.blog.edit');
	Route::post('/blog/update/{id}', [App\Http\Controllers\BlogController::class, 'postEditBlog'])->name('admin.blog.postedit');
	Route::get('/blog/delete/{id}', [App\Http\Controllers\BlogController::class, 'deleteBlog']);


	Route::get('/metalcolor', [App\Http\Controllers\RingMetalController::class, 'metalColorList'])->name('admin.metal.color');
	Route::get('/metalcolor/add', [App\Http\Controllers\RingMetalController::class, 'createColor'])->name('admin.metalcolor.view');
	Route::post('/metalcolor/add', [App\Http\Controllers\RingMetalController::class, 'postcreateColor'])->name('admin.metalcolor.add');
	Route::get('/metalcolor/edit/{id}', [App\Http\Controllers\RingMetalController::class, 'editMetalColor'])->name('admin.metalcolor.edit');
	Route::post('/metalcolor/update/{id}', [App\Http\Controllers\RingMetalController::class, 'postEditMetalColor'])->name('admin.update.metalcolor');
	Route::get('/deletemetalcolor/{id}', [App\Http\Controllers\RingMetalController::class, 'deleteMetalColor']);
	Route::get('/home-content', [App\Http\Controllers\HomeContentController::class, 'index'])->name('admin.homecontent');
	Route::post('/home-content', [App\Http\Controllers\HomeContentController::class, 'update'])->name('admin.homecontent.update');

	Route::get('/widget', [App\Http\Controllers\FaqController::class, 'widgetList'])->name('admin.widget.list');

	Route::get('/widget/add', [App\Http\Controllers\FaqController::class, 'createwidget'])->name('admin.widget.create');
	Route::post('/widget/add', [App\Http\Controllers\FaqController::class, 'postCreatewidget'])->name('admin.widget.postcreate');
	Route::get('/widget/edit/{id}', [App\Http\Controllers\FaqController::class, 'editWidget'])->name('admin.edit.widget');
	Route::post('/widget/{id}', [App\Http\Controllers\FaqController::class, 'postEditWidget'])->name('admin.update.widget');
	Route::get('/deletewidget/{id}', [App\Http\Controllers\FaqController::class, 'deleteWidget']);


	Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.list');
	Route::get('/users/add', [App\Http\Controllers\UserController::class, 'createUser'])->name('admin.users.create');
	Route::post('/users/add', [App\Http\Controllers\UserController::class, 'postCreateUser'])->name('admin.users.postcreate');
	Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'editUser'])->name('admin.edit.users');
	Route::post('/users/{id}', [App\Http\Controllers\UserController::class, 'postEditUser'])->name('admin.update.users');
	Route::get('/deleteuser/{id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('admin.deleteadmin.user');

	Route::get('/role', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.role.list');
	Route::get('/role/add', [App\Http\Controllers\RoleController::class, 'addRole'])->name('admin.role.create');
	Route::post('/role/add', [App\Http\Controllers\RoleController::class, 'postaddRole'])->name('admin.role.postcreate');
	Route::get('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'editRole'])->name('admin.role.edit');
	Route::post('/role/{id}', [App\Http\Controllers\RoleController::class, 'postEditRole'])->name('admin.role.update');

	Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('admin.permission.list');
	Route::get('/permissions/add', [App\Http\Controllers\PermissionController::class, 'addPermission'])->name('admin.permission.create');
	Route::post('/permissions/add', [App\Http\Controllers\PermissionController::class, 'postAdd'])->name('admin.users.postadd');
	Route::get('/permissions/edit/{id}', [App\Http\Controllers\PermissionController::class, 'editPermission'])->name('admin.edit.permission');
	Route::get('/permissions/edit/{id}', [App\Http\Controllers\PermissionController::class, 'editPermission'])->name('admin.edit.permission');
	Route::post('/permissions/{id}', [App\Http\Controllers\PermissionController::class, 'postEditPermission'])->name('admin.update.permission');

	Route::get('/orders', [App\Http\Controllers\OrderController::class, 'orders'])->name('sale.orders');
	Route::get('/orders/invoice/{order_id}', [App\Http\Controllers\OrderController::class, 'makeInvoice'])->name('order.invoice');
	Route::get('/invoice/{order_id}',[App\Http\Controllers\InvoiceController::class, 'invoicePdf'])->name('sale.orders.invoice.download');
	Route::get('/order-detail/{id}', [App\Http\Controllers\OrderController::class, 'ordersDetail'])->name('sale.orders.detail');
	Route::get('/shipments', [App\Http\Controllers\SaleController::class, 'shipments'])->name('sale.shipments');
	Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('sale.invoices');
	Route::get('/invoices/view/{order_id}', [App\Http\Controllers\InvoiceController::class, 'viewInvoice'])->name('order.invoices.view');
	Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('sale.transactions');
	Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('sale.report');


	//gemstone filters

	Route::get('/gemstones', [App\Http\Controllers\GemstoneAttributeController::class, 'gemstones'])->name('admin.gemstone.list');
	Route::get('/gemstones/add', [App\Http\Controllers\GemstoneAttributeController::class, 'addGemstone'])->name('admin.gemstone.add');
	Route::post('/gemstones/add', [App\Http\Controllers\GemstoneAttributeController::class, 'gemstoneStore'])->name('admin.gemstone.store');
	Route::get('/gemstones/edit/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'gemstoneEdit'])->name('admin.gemstone.edit');
	Route::post('/gemstones/edit/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'gemstoneUpdate'])->name('admin.gemstone.update');
	Route::get('/gemstones/delete/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'deleteGemstone']);

	##shape
	Route::get('/stoneshape', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneShape'])->name('admin.shape.list');
	Route::get('/stoneshape/add', [App\Http\Controllers\GemstoneAttributeController::class, 'addStoneShape'])->name('admin.shape.add');
	Route::post('/stoneshape/add', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneShapeStore'])->name('admin.shape.store');
	Route::get('/stoneshape/edit/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneShapeEdit'])->name('admin.shape.edit');
	Route::post('/stoneshape/edit/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneShapeUpdate'])->name('admin.shape.update');
	Route::get('/stoneshape/delete/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneShapeDelete']);

	##stone color
	Route::get('/stonecolor', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneColor'])->name('admin.color.list');
	Route::get('/stonecolor/add', [App\Http\Controllers\GemstoneAttributeController::class, 'addStoneColor'])->name('admin.color.add');
	Route::post('/stonecolor/add', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneColorStore'])->name('admin.color.store');
	Route::get('/stonecolor/edit/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneColorEdit'])->name('admin.color.edit');
	Route::post('/stonecolor/edit/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneColorUpdate'])->name('admin.color.update');
	Route::get('/stonecolor/delete/{id}', [App\Http\Controllers\GemstoneAttributeController::class, 'stoneColorDelete']);

	//gemstone filters

	// filter data uri
	Route::get('/filter-category/{id}', [App\Http\Controllers\FilterDataController::class, 'filterCategory']);
	Route::get('/filter-subcategory/{menu}/{category}', [App\Http\Controllers\FilterDataController::class, 'filterSubCategory']);
	Route::post('/filter-product', [App\Http\Controllers\FilterDataController::class, 'filterProduct']);
	Route::post('/add-similar-product', [App\Http\Controllers\FilterDataController::class, 'addSimilarProduct'])->name('admin.product.similar');
	Route::post('/similar-product/remove', [App\Http\Controllers\FilterDataController::class, 'removeSimilarProduct'])->name('admin.remove.similar');


	Route::get('/product/check', [App\Http\Controllers\ProductController::class, 'Testing']);
	Route::get('/price/discount', [App\Http\Controllers\ProductPriceDiscount::class, 'index'])->name('price.discount');
	Route::post('/price/discount', [App\Http\Controllers\ProductPriceDiscount::class, 'update'])->name('price.discount.update');
});
	// });
