<?php

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

Route::get('page-404', function(){
	return response()->view('errors.404', [], 404);
})->name('404');

$adminPath = config('admin.path');
 
Route::get($adminPath . '/login', 'Admin\LoginController@showLoginForm', ['guard' => 'admin'])->name('admin_login');
Route::post($adminPath . '/login', 'Admin\LoginController@login', ['guard' => 'admin'])->name('admin_run_login'); 

Route::group(['prefix' => $adminPath, 'namespace' => 'Admin', 'middleware' => ['admin', 'web']], function() { 
	Route::get('/', function(){
		return redirect()->route('admin_menu');
	});
	
	Route::group(['prefix' => 'menu'], function() { 
		Route::get('/', 'MenuController@show')->name('admin_menu');  
		Route::get('{id}/edit', 'MenuController@showeditForm'); 
		Route::get('add', 'MenuController@showAddForm');
		Route::post('create', 'MenuController@create'); 
		Route::post('{id}/update', 'MenuController@update'); 
	});

    Route::group(['prefix' => 'constants'], function() {
        Route::get('/', 'ConstantsController@show')->name('admin_constants');
        Route::post('create', 'ConstantsController@create');
        Route::post('createConstant', 'ConstantsController@createConstant');
    });

	Route::group(['prefix' => 'languages'], function() { 
		Route::get('/', 'LanuagesController@show')->name('admin_languages');  
		Route::get('{id}/edit', 'LanuagesController@showeditForm'); 
		Route::get('add', 'LanuagesController@showAddForm');
		Route::post('create', 'LanuagesController@create'); 
		Route::post('{id}/update', 'LanuagesController@update'); 
	}); 

	Route::group(['prefix' => 'slider'], function() { 
		Route::get('/', 'SliderController@show')->name('admin_slider');  
		Route::get('{id}/edit', 'SliderController@showeditForm'); 
		Route::get('add', 'SliderController@showAddForm');
		Route::post('create', 'SliderController@create'); 
		Route::post('{id}/update', 'SliderController@update'); 
	});

    Route::group(['prefix' => 'e-vouchers'], function() {
        Route::get('/', 'EvouchersController@show')->name('admin_evouchers');
        Route::get('{id}/edit', 'EvouchersController@showeditForm');
        Route::get('add', 'EvouchersController@showAddForm');
        Route::post('create', 'EvouchersController@create');
        Route::post('{id}/update', 'EvouchersController@update');
    });

    Route::group(['prefix' => 'transaction-types'], function() {
        Route::get('/', 'TransactionTypesController@show')->name('admin_transaction_types');
        Route::get('{id}/edit', 'TransactionTypesController@showeditForm'); 
        Route::post('{id}/update', 'TransactionTypesController@update');
    });

    Route::group(['prefix' => 'email-templates'], function() {
        Route::get('/', 'EmailTemplatesController@show')->name('admin_email_templates');
        Route::get('{id}/edit', 'EmailTemplatesController@showeditForm'); 
        Route::post('{id}/update', 'EmailTemplatesController@update');
    });

    $auctionTypes = ['specific', 'classical'];
    foreach($auctionTypes as $key => $type)
    {
        Route::group(['prefix' => $type . '-auctions'], function() use($type) {
            Route::group(['prefix' => 'auctions'], function() use($type) {
                Route::get('/', 'AuctionsController@show')->name($type.'_admin_auctions');
                Route::get('{id}/edit', 'AuctionsController@showeditForm');
                Route::get('add', 'AuctionsController@showAddForm');
                Route::post('create', 'AuctionsController@create');
                Route::post('{id}/update', 'AuctionsController@update');
            });
        });
    }

    Route::group(['prefix' => 'banners'], function() {
        Route::get('/', 'BannerController@show')->name('admin_banner');
        Route::get('{id}/edit', 'BannerController@showeditForm');
        Route::get('add', 'BannerController@showAddForm');
        Route::post('create', 'BannerController@create');
        Route::post('{id}/update', 'BannerController@update');
    });

    Route::group(['prefix' => 'settings'], function() {
        Route::get('/', 'SettingsController@show')->name('admin_settings');
        Route::post('save', 'SettingsController@save');
    });

    Route::group(['prefix' => 'front-page'], function() {
        Route::group(['prefix' => 'testimonials'], function() {
            Route::get('/', 'TestimonialsController@show')->name('admin_testimonials');
            Route::get('{id}/edit', 'TestimonialsController@showeditForm');
            Route::get('add', 'TestimonialsController@showAddForm');
            Route::post('create', 'TestimonialsController@create');
            Route::post('{id}/update', 'TestimonialsController@update');
        });
    });

    Route::group(['prefix' => 'statistics'], function() {
        Route::get('daily-reports', 'StatisticsController@dailyReports')->name('admin_daily_reports');  
        Route::get('client-history', 'StatisticsController@clientHistory')->name('admin_client_history'); 
    });

    Route::group(['prefix' => 'orders'], function() {
        Route::group(['prefix' => 'status', 'namespace' => 'Orders'], function() {
            Route::get('/', 'OrdersStatusController@show')->name('admin_orders_status');
            Route::get('{id}/edit', 'OrdersStatusController@showeditForm');
            Route::get('add', 'OrdersStatusController@showAddForm');
            Route::post('create', 'OrdersStatusController@create');
            Route::post('{id}/update', 'OrdersStatusController@update');
        });

        Route::group(['prefix' => 'orders-list', 'namespace' => 'Orders'], function() {
            Route::get('/', 'OrdersListController@show')->name('admin_orders_list');
            Route::get('{id}/edit', 'OrdersListController@showeditForm');
            Route::get('add', 'OrdersListController@showAddForm');
            Route::post('create', 'OrdersListController@create');
            Route::post('{id}/update', 'OrdersListController@update');

            Route::post('{id}/change-status', 'OrdersListController@changeStatus')->name('change_order_status');
        });  
    }); 

    Route::group(['prefix' => 'clients'], function() {
        Route::get('/', 'ClientsController@show')->name('admin_clients');
        Route::get('{id}/edit', 'ClientsController@showeditForm');
        Route::get('add', 'ClientsController@showAddForm');
        Route::post('create', 'ClientsController@create');
        Route::post('{id}/update', 'ClientsController@update');
        Route::post('{id}/send-letter', 'ClientsController@sendLetter');
        Route::get('{id}/autologin', 'ClientsController@autologin'); 
    });

	Route::group(['prefix' => 'profile'], function() { 
		Route::get('/', 'ProfileController@showForm')->name('profile');
		Route::post('edit', 'ProfileController@edit');
		Route::post('addNewUser', 'ProfileController@addNewUser');
        Route::get('/logs-report/{id_user}', 'ProfileController@showLogsReport');
	}); 
  
	Route::group(['prefix' => 'user', 'namespace' => 'Users',], function() { 
		Route::post('fastRegister', 'SiteUser@fastRegister');  
	});

	Route::group(['prefix' => 'ajax'], function() {  
		Route::post('depth-sort', 'AjaxController@depthSort')->name('depth_sort');
		Route::post('viewElement', 'AjaxController@viewElement')->name('viewElement'); 
		Route::post('deleteElement', 'AjaxController@deleteElement')->name('deleteElement');   
		Route::post('deleteImg', 'AjaxController@deleteImg')->name('deleteImg');
        Route::post('sortElement', 'AjaxController@sortElement')->name('sortElement');
	}); 

	Route::get('logout', 'LoginController@logout')->name('admin_logout'); 
});


Route::get('/', 'HomeController@index')->middleware(['lang', 'web']);

Route::post('messages', function(\Illuminate\Http\Request $request){ 
    \App\Events\ItemAdded::dispatch($request->body);
});

Route::group(['prefix' => '{lang}', 'middleware' => ['lang', 'web']], function() {

    Route::get('test', 'HomeController@test'); 

    Route::get('/', 'HomeController@index');

    Route::group(['prefix' => 'results'], function() {
        Route::get('/', 'ResultsController@index')->name('results');
        Route::get('{id_result}/bids', 'ResultsController@bids')->name('results_bids'); 
    });
  
    Route::group(['middlewars' => 'guest'], function(){
        Route::post('register', 'Auth\RegisterController@register')->name('register');
        Route::get('finish-registration', 'Auth\RegisterController@finish_registration')->name('finish_registration');
        Route::get('registration-confirm/{confirmation_hash}', 'Auth\RegisterController@confirmation')->name('registration_confirm');
        Route::post('login', 'Auth\LoginController@login')->name('login');
        Route::post('reset-password', 'Auth\ForgotPasswordController@sendResetPassword')->name('send_reset_pass');

        Route::group(['prefix' => 'profile', 'namespace' => 'User', 'middleware' => 'web_auth'], function() {
            Route::get('personal-data', 'ProfileController@personalData')->name('personal_data');
            Route::post('personal-data', 'ProfileController@savePersonalData')->name('save_personal_data');

            Route::get('change-password', 'ProfileController@changePass')->name('change_pass');
            Route::post('change-password', 'ProfileController@savePassword')->name('save_new_password');

            Route::group(['prefix' => 'register'], function() {
                Route::get('offers-placed', 'RegisterController@offersPlaced')->name('offers_placed');
                Route::get('transactions', 'RegisterController@transactions')->name('transactions');
                Route::get('orders', 'RegisterController@orders')->name('orders');
               // Route::get('bids', 'RegisterController@bids')->name('register_bids');
            });
        });
    });

    Route::group(['prefix' => 'cart', 'namespace' => 'Cart'], function() {
        Route::get('empty', 'CartController@empty_cart')->name('empty_cart');
        Route::get('view/{id?}', 'CartController@view')->name('view_cart');
        Route::post('order/{id}', 'CartController@order')->name('order');
        Route::get('success/{id}', 'CartController@success')->name('success_cart');

        Route::get('delete/{id}', 'CartController@delete')->name('delete_cart_item');
    });

    $classicalAuctionUrl = \Pages::pageData('classical-auctions')->url;
    Route::get($classicalAuctionUrl, 'Auctions\ClassicAuctionController@index');
    Route::get("{$classicalAuctionUrl}/{url}", 'Auctions\ClassicAuctionController@show');
    Route::post("{$classicalAuctionUrl}/add-bid/{id}", 'Auctions\ClassicAuctionController@addBid')->middleware('web_auth');

    $classicalAuctionUrl = \Pages::pageData('specific-auctions')->url;
    Route::get($classicalAuctionUrl, 'Auctions\SpecificAuctionController@index');
    Route::get("{$classicalAuctionUrl}/{url}", 'Auctions\SpecificAuctionController@show');
    Route::post("{$classicalAuctionUrl}/add-bid/{id}", 'Auctions\SpecificAuctionController@addBid')->middleware('web_auth');

    /*
     * Routes for authorized users
     */
    Route::group(['middleware' => ['web_auth']], function(){
        Route::get('logout', function(){
            Auth::guard('web')->logout();
            return  redirect('/');
        })->name('logout');
    });


    /*
     * If not exist route
     */
    Route::get('{any}', 'HomeController@page');
});



//Auth::routes();

