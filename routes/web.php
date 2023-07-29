<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', function () {
    return view('login');
})->middleware('guest');


Auth::routes([
    'login' => false,
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);



Route::get('/get-user', function(){
    if(Auth::check()){
        return Auth::user();
    }

    return [];
});



Route::post('/custom-login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/sample',[App\Http\Controllers\SampleController::class,'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//for open request
//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);

Route::get('/load-acadyears', [App\Http\Controllers\AddressController::class, 'loadAcadYears']);

/*     ADMINSITRATOR          */

//authenticate
Route::middleware(['auth'])->group(function() {

    Route::resource('/dashboard', App\Http\Controllers\Administrator\DashboardController::class);
    
    Route::resource('/offices', App\Http\Controllers\Administrator\OfficeController::class);
    Route::get('/get-offices', [App\Http\Controllers\Administrator\OfficeController::class, 'getOffices']);
    Route::get('/get-offices-for-routes', [App\Http\Controllers\Administrator\OfficeController::class, 'getOfficesForRoutes']);
});


Route::middleware(['auth', 'admin'])->group(function() {

    Route::resource('/academic-years', App\Http\Controllers\Administrator\AcademicYearController::class);
    Route::get('/get-academic-years', [App\Http\Controllers\Administrator\AcademicYearController::class, 'getData']);

    Route::resource('/courses', App\Http\Controllers\Administrator\CourseController::class);
    Route::get('/get-courses', [App\Http\Controllers\Administrator\CourseController::class, 'getData']);

    Route::resource('/faculty', App\Http\Controllers\Administrator\FacultyController::class);
    Route::get('/get-faculty', [App\Http\Controllers\Administrator\FacultyController::class, 'getData']);


    Route::get('/faculty-loads/{id}', [App\Http\Controllers\Administrator\FacultyLoadController::class, 'index']);
    Route::get('/get-faculty-loads', [App\Http\Controllers\Administrator\FacultyLoadController::class, 'getData']);
    Route::get('/get-individual-loads/{id}/{acadyearId}', [App\Http\Controllers\Administrator\FacultyLoadController::class, 'getIndividualLoads']);
    Route::get('/get-modal-schedules', [App\Http\Controllers\Administrator\FacultyLoadController::class, 'getModalSchedules']);
    Route::post('/faculty-load-store', [App\Http\Controllers\Administrator\FacultyLoadController::class, 'store']);

    
    Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
    Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);
    
    Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
    Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);
    

});


/*     ADMINSITRATOR          */

Route::get('/session', function(){
    return Session::all();
});


Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();
});


//hello kigwa//
//Testing



Route::get('/test', function(){
    return 'hi i am test';
});

//something
//something merge conflict will happen

