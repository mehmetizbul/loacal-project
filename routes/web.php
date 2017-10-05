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
use Illuminate\Support\Facades\Route;
Route::post('/experience/images/upload', ['as' => 'upload-post', 'uses' =>'OfflineExperiencesController@imagesUpload']);
Route::post('/experience/images/delete', ['as' => 'upload-remove', 'uses' =>'OfflineExperiencesController@imagesDelete']);
Route::post('/experience/images/uploadCroppedFeatured', ['as' => 'upload-cropped-featured', 'uses' =>'OfflineExperiencesController@uploadCroppedFeatured']);
Route::post('/experience/images/uploadFeatured', ['as' => 'upload-featured', 'uses' =>'OfflineExperiencesController@uploadFeatured']);
Route::post('/experience/images/makeFeatured', ['as' => 'make-featured', 'uses' =>'OfflineExperiencesController@makeFeatured']);

Route::post('/booking/calculate', ['as' => 'booking.calculate', 'uses' =>'BookingRequestController@calculate']);
Route::post('/booking/create', ['as' => 'booking.create', 'uses' =>'BookingRequestController@create']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
    ],
    function() {

        Route::get('/requests', function(){
            return view('user.booking-requests');
        });


        Route::get('/profile/{slug}', 'AccountController@profile');
        //Counter::count('/');
        Route::get('/', ['as'=>'experience.homepage','uses'=>'ExperiencesController@homepage']);

        Route::get('/experience/dynamictopexperience', ['as'=>'experience.dynamictopexperience','uses'=>'ExperiencesController@dynamictopexperience']);
        Route::get('/experience/dynamicwithlocal', ['as'=>'experience.dynamicwithlocal','uses'=>'ExperiencesController@dynamicwithlocal']);

        Auth::routes();

        Route::get('/my-account','AccountController@account')->middleware('auth');
        Route::get('/my-account/edit','AccountController@edit')->middleware('auth');
        Route::get('/my-account/my-experiences/', function () {
            return view('user.my-experiences');
        });
        Route::post('/my-account','LoacalApplicationsController@store')->middleware('auth');
        Route::get('/tour-guide-registration','LoacalApplicationsController@create')->middleware('auth');

        Route::get('/about-us','PageController@aboutus');


        Route::get('/terms-and-conditions', function(){
            return view('loacal.termsandconditions');
        });
        Route::get('/faq', function(){
            return view('loacal.faq');
        });
        Route::get('/feedback', function(){
            return view('loacal.feedback');
        });
        Route::get('/cancellation', function(){
            return view('loacal.cancellationandrefund');
        });
        Route::get('/how-it-works', function(){
            return view('loacal.howitworks');
        });
        Route::get('/what-is-a-loacal', function(){
            return view('loacal.whatisaloacal');
        });
        Route::get('/contact-us', function(){
            return view('loacal.contactus');
        });
        Route::get('/careers', function(){
            return view('loacal.careers');
        });



        Route::get('user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');

        Route::resource('users','UserController');
        Route::resource('loacal-applications','LoacalApplicationsController');

        //Route::resource('experience','ExperiencesController');

        Route::get('experiences',['as'=>'experience.index','uses'=>'ExperiencesController@index']);
        Route::get('experience/create',['as'=>'experience.create','uses'=>'OfflineExperiencesController@create']);
        Route::post('experience/create',['as'=>'experience.store','uses'=>'OfflineExperiencesController@store']);
        Route::get('experience/{slug}',['as'=>'experience.show','uses'=>'ExperiencesController@show']);
        Route::get('experience/{id}/edit',['as'=>'experience.edit','uses'=>'OfflineExperiencesController@edit']);
        Route::patch('experience/{id}',['as'=>'experience.update','uses'=>'OfflineExperiencesController@update']);
        Route::delete('experience/{id}',['as'=>'experience.destroy','uses'=>'ExperiencesController@destroy']);
        Route::get('/experience/{token}/edit/images','OfflineExperiencesController@images');
        Route::get('experiences/manage/{status?}',['as'=>'experience.manage','uses'=>'ExperiencesController@manage','middleware' => ['role:admin|super_admin']]);
        Route::post('experience/{id}',['as'=>'experience.accept','uses'=>'OfflineExperiencesController@accept']);
        Route::get('experience/{id}/make_editable',['as'=>'experience.make_editable','uses'=>'ExperiencesController@make_editable']);
        Route::get('experience/{id}/view',['as'=>'experience.view','uses'=>'OfflineExperiencesController@view']);

        Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['role:admin|super_admin']]);
        Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['role:super_admin']]);
        Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['role:super_admin']]);
        Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
        Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['role:super_admin']]);
        Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['role:super_admin']]);
        Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['role:super_admin']]);
        
        Route::get('categories',['as'=>'categories.index','uses'=>'CategoryController@index','middleware' => ['role:admin|super_admin']]);
        Route::get('categories/create',['as'=>'categories.create','uses'=>'CategoryController@create','middleware' => ['role:super_admin']]);
        Route::post('categories/create',['as'=>'categories.store','uses'=>'CategoryController@store','middleware' => ['role:super_admin']]);
        Route::get('categories/{id}',['as'=>'categories.show','uses'=>'CategoryController@show']);
        Route::get('categories/{id}/edit',['as'=>'categories.edit','uses'=>'CategoryController@edit','middleware' => ['role:super_admin']]);
        Route::patch('categories/{id}',['as'=>'categories.update','uses'=>'CategoryController@update','middleware' => ['role:super_admin']]);
        Route::delete('categories/{id}',['as'=>'categories.destroy','uses'=>'CategoryController@destroy','middleware' => ['role:super_admin']]);
        Route::get('categories/{id}/subs.json',['as'=>'categories.subs','uses'=>'CategoryController@subs']);

        Route::get('certificates',['as'=>'certificates.index','uses'=>'CertificateController@index','middleware' => ['role:admin|super_admin']]);
        Route::get('certificates/create',['as'=>'certificates.create','uses'=>'CertificateController@create','middleware' => ['role:super_admin']]);
        Route::post('certificates/create',['as'=>'certificates.store','uses'=>'CertificateController@store','middleware' => ['role:super_admin']]);
        Route::get('certificates/{id}',['as'=>'certificates.show','uses'=>'CertificateController@show']);
        Route::get('certificates/{id}/edit',['as'=>'certificates.edit','uses'=>'CertificateController@edit','middleware' => ['role:super_admin']]);
        Route::patch('certificates/{id}',['as'=>'certificates.update','uses'=>'CertificateController@update','middleware' => ['role:super_admin']]);
        Route::delete('certificates/{id}',['as'=>'certificates.destroy','uses'=>'CertificateController@destroy','middleware' => ['role:super_admin']]);

        Route::get('languages',['as'=>'languages.index','uses'=>'LanguageController@index','middleware' => ['role:admin|super_admin']]);
        Route::get('languages/create',['as'=>'languages.create','uses'=>'LanguageController@create','middleware' => ['role:super_admin']]);
        Route::post('languages/create',['as'=>'languages.store','uses'=>'LanguageController@store','middleware' => ['role:super_admin']]);
        Route::get('languages/{id}',['as'=>'languages.show','uses'=>'LanguageController@show']);
        Route::get('languages/{id}/edit',['as'=>'languages.edit','uses'=>'LanguageController@edit','middleware' => ['role:super_admin']]);
        Route::patch('languages/{id}',['as'=>'languages.update','uses'=>'LanguageController@update','middleware' => ['role:super_admin']]);
        Route::delete('languages/{id}',['as'=>'languages.destroy','uses'=>'LanguageController@destroy','middleware' => ['role:super_admin']]);

        Route::get('countries',['as'=>'countries.index','uses'=>'CountryController@index','middleware' => ['role:admin|super_admin']]);
        Route::get('countries/create',['as'=>'countries.create','uses'=>'CountryController@create','middleware' => ['role:super_admin']]);
        Route::post('countries/create',['as'=>'countries.store','uses'=>'CountryController@store','middleware' => ['role:super_admin']]);
        Route::get('countries/{id}',['as'=>'countries.show','uses'=>'CountryController@show']);
        Route::get('countries/{id}/edit',['as'=>'countries.edit','uses'=>'CountryController@edit','middleware' => ['role:super_admin']]);
        Route::patch('countries/{id}',['as'=>'countries.update','uses'=>'CountryController@update','middleware' => ['role:super_admin']]);
        Route::delete('countries/{id}',['as'=>'countries.destroy','uses'=>'CountryController@destroy','middleware' => ['role:super_admin']]);

        Route::get('location/city',['as'=>'location.city','uses'=>'CountryController@citycontainer']);
        Route::get('location/area',['as'=>'location.area','uses'=>'CountryController@areacontainer']);
        Route::get('location/country',['as'=>'location.country','uses'=>'CountryController@locationcontainer']);

    });


Route::group(['prefix' => 'bookingrequest'], function () {
    Route::get('/', ['as' => 'booking', 'uses' => 'BookingRequestController@requests']);
    Route::get('/messages/{id}', ['as' => 'booking.messages', 'uses' => 'BookingRequestController@messages']);
    Route::put('/payment', ['as' => 'booking.payment', 'uses' => 'BookingRequestController@payment']);
    Route::get('/{id}', ['as' => 'booking.thread', 'uses' => 'BookingRequestController@thread']);
    Route::put('/{id}', ['as' => 'booking.update_messaging', 'uses' => 'BookingRequestController@update_messaging']);
    Route::put('/update/{id}', ['as' => 'booking.update_booking', 'uses' => 'BookingRequestController@update_booking']);

});



