<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home']);
Route::get('/service/{id}', [HomeController::class, 'service_detail']);
Route::get('page/about-us', [PageController::class, 'about_us']);
Route::get('page/contact-us', [PageController::class, 'contact_us']);



// Admin Dashboard
Route::get('/admin', [AdminController::class, 'dashboard']);

Route::prefix('admin')->group(function (){

    // Login Dashboard
    Route::get('/login', [AdminController::class, 'login']);
    Route::post('/login', [AdminController::class, 'check_login']);
    Route::get('/logout', [AdminController::class, 'logout']);


    // RoomType Dashboard
    Route::resource('/room-type', RoomTypeController::class);
    Route::get('/room-type/{id}/delete', [RoomTypeController::class, 'destroy']);

    // Delete Image
    Route::get('/roomtypeimage/delete/{id}',[RoomtypeController::class,'destroy_image']);

    // Room Dashboard
    Route::resource('/room', RoomController::class);
    Route::get('/room/{id}/delete', [RoomController::class, 'destroy']);

    // Customer Dashboard
    Route::resource('/customer', CustomerController::class);
    Route::get('/customer/{id}/delete', [CustomerController::class, 'destroy']);

    // Department Dashboard
    Route::resource('/department', DepartmentController::class);
    Route::get('/department/{id}/delete', [DepartmentController::class, 'destroy']);

    // Staff Dashboard
    Route::resource('/staff', StaffController::class);
    Route::get('/staff/{id}/delete', [StaffController::class, 'destroy']);

    //Staff Payment
    Route::get('/staff/payments/{id}',[StaffController::class,'all_payments']);
    Route::get('/staff/payment/{id}/add',[StaffController::class,'add_payment']);
    Route::post('/staff/payment/{id}',[StaffController::class,'save_payment']);
    Route::get('/staff/payment/{id}/{staff_id}/delete',[StaffController::class,'delete_payment']);

    //Bookings Dashboard
    Route::resource('/booking', BookingController::class);
    Route::get('/booking/{id}/delete', [BookingController::class, 'destroy']);
    Route::get('/booking/available-rooms/{checkin_date}', [BookingController::class, 'available_rooms']);

    // Services Dashboard
    Route::resource('/service', ServiceController::class);
    Route::get('/service/{id}/delete', [ServiceController::class, 'destroy']);

    //Testimonials
    Route::get('/testimonials', [AdminController::class, 'testimonials']);
    Route::get('/testimonials/{id}/delete', [AdminController::class, 'destroy_testimonial']);

    // Banners Dashboard
    Route::resource('/banner', BannerController::class);
    Route::get('/banner/{id}/delete', [BannerController::class, 'destroy']);

});

//Customer Login
Route::get('login', [CustomerController::class, 'login']);
Route::post('customer/login', [CustomerController::class, 'customer_login']);
Route::get('register', [CustomerController::class, 'register']);
Route::get('logout', [CustomerController::class, 'logout']);

//Customer Booking
Route::get('booking', [BookingController::class, 'front_booking']);
Route::get('booking/success',[BookingController::class,'booking_payment_success']);
Route::get('booking/fail',[BookingController::class,'booking_payment_fail']);

// Testimonial
Route::get('customer/add-testimonial', [HomeController::class, 'add_testimonial']);
Route::post('customer/save-testimonial', [HomeController::class, 'save_testimonial']);
Route::post('save-contactus', [PageController::class, 'save_contactus']);
