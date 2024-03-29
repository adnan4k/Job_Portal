<?php

use App\Http\Controllers\ApplicantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostJobController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\isEmployer;
use App\Http\Middleware\isPremiumUser;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Stripe\Subscription;

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

 
// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');
 Route::get('/',[HomeController::class,'index']);
 Route::get('/register/seeker',[UserController::class,'createSeeker'])->name('create.seeker')->middleware(CheckAuth::class);
 Route::post('/register/seeker',[UserController::class,'storeSeeker'])->name('store.seeker')->middleware(CheckAuth::class);
 Route::get('/register/employer',[UserController::class,'createEmployer'])->name('create.employer')->middleware(CheckAuth::class);
 Route::post('/register/employer',[UserController::class,'storeEmployer'])->name('store.employer')->middleware(CheckAuth::class);
 Route::get('/login',[UserController::class,'login'])->name('login')->middleware(CheckAuth::class);
 Route::post('/login',[UserController::class,'postLogin'])->name('login.post');
 Route::post('/logout',[UserController::class,'logout'])->name('logout');
//  Route::get('/verify',[DashboardController::class,'verify'])->name('verification.notice');
 Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')
 ->middleware('auth')
 ->middleware(isEmployer::class);

 Route::get('/user/profile',[UserController::class,'profile'])->name('user.profile')->middleware('auth');
 Route::post('/user/profile',[UserController::class,'update'])->name('user.update.profile')->middleware('auth');
 Route::get('/user/seeker/profile',[UserController::class,'seekerProfile'])->name('seeker.profile')->middleware('auth');
 Route::post('/user/password',[UserController::class,'changePassword'])->name('seeker.password')->middleware('auth');
 Route::post('/user/resume',[UserController::class,'uploadResume'])->name('upload.resume')->middleware('auth');


 Route::get('/subscribe',[SubscriptionController::class,'subscribe'])->name('subscribe');
 Route::get('/pay/weekly',[SubscriptionController::class,'initiatePayment'])->name('pay.weekly');
 Route::get('/pay/monthly',[SubscriptionController::class,'initiatePayment'])->name('pay.monthly');
 Route::get('/pay/yearly',[SubscriptionController::class,'initiatePayment'])->name('pay.yearly');
 Route::get('/payment/success',[SubscriptionController::class,'paymentSuccess'])->name('payment.success');
 Route::get('/payment/cancel',[SubscriptionController::class,'cancel'])->name('payment.cancel');
 Route::get('/job/create',[PostJobController::class,'create'])->name('job.create')->middleware(isPremiumUser::class);
 Route::post('/job/store',[PostJobController::class,'store'])->name('job.store')->middleware(isPremiumUser::class);
 Route::get('/job/{listing}/edit',[PostJobController::class,'edit'])->name('job.edit')->middleware(isPremiumUser::class);
 Route::put('/job/{id}/update',[PostJobController::class,'update'])->name('job.update')->middleware(isPremiumUser::class);
 Route::get('/job',[PostJobController::class,'index'])->name('job.index');
 Route::delete('/job/{id}/delete',[PostJobController::class,'destroy'])->name('job.delete');


 Route::get('applicants',[ApplicantController::class,'index'])->name('applicants.index');
 Route::get('applicants/{listing:slug}',[ApplicantController::class,'show'])->name('applicants.show');
 Route::get('shortlist/{listingId}/{userId}',[ApplicantController::class,'shortlist'])->name('applicants.shortlist');



