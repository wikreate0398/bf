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



Route::get('/', 'HomeController@index');

$adminPath = config('admin.path');

Route::get($adminPath . '/login', 'Admin\LoginController@showLoginForm', ['guard' => 'admin'])->name('admin_login');
Route::post($adminPath . '/login', 'Admin\LoginController@login', ['guard' => 'admin'])->name('admin_run_login'); 

Route::group(['prefix' => $adminPath, 'namespace' => 'Admin', 'middleware' => 'admin'], function() { 
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


    Route::group(['prefix' => 'auctions'], function() {
        Route::group(['prefix' => 'auctions'], function() {
            Route::get('/', 'AuctionsController@show')->name('admin_auctions');
            Route::get('{id}/edit', 'AuctionsController@showeditForm');
            Route::get('add', 'AuctionsController@showAddForm');
            Route::post('create', 'AuctionsController@create');
            Route::post('{id}/update', 'AuctionsController@update');
        });

        Route::group(['prefix' => 'auction-types'], function() {
            Route::get('/', 'AuctionTypesController@show')->name('admin_auction_types');
            Route::get('{id}/edit', 'AuctionTypesController@showeditForm');
            Route::get('add', 'AuctionTypesController@showAddForm');
            Route::post('create', 'AuctionTypesController@create');
            Route::post('{id}/update', 'AuctionTypesController@update');
        });

        Route::group(['prefix' => 'product-types'], function() {
            Route::get('/', 'ProductTypesController@show')->name('admin_product_types');
            Route::get('{id}/edit', 'ProductTypesController@showeditForm');
            Route::get('add', 'ProductTypesController@showAddForm');
            Route::post('create', 'ProductTypesController@create');
            Route::post('{id}/update', 'ProductTypesController@update');
        });
    });

    Route::group(['prefix' => 'banners'], function() {
        Route::get('/', 'BannerController@show')->name('admin_banner');
        Route::get('{id}/edit', 'BannerController@showeditForm');
        Route::get('add', 'BannerController@showAddForm');
        Route::post('create', 'BannerController@create');
        Route::post('{id}/update', 'BannerController@update');
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



