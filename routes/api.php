<?php

use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\CounterController;
use App\Http\Controllers\API\NewsletterController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\PortfolioController;
use App\Http\Controllers\API\FeeController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\FollowupController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\ProcessController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\PartnerController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\VaccancyController;
use App\Http\Requests\API\ComplainRequest;
use App\Http\Requests\API\VaccancyRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteProductProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('faqs', 'FaqController@index');
// Route::get('faqs/{id}', 'FaqController@show');
// Route::get('processes', 'ProcessController@index');
// Route::get('processes/{id}', 'ProcessController@show');
// Route::get('partners', 'PartnerController@index');
// Route::get('partners/{id}', 'PartnerController@show');
// Route::get('counters', 'CounterController@index');
// Route::get('counter/{id}', 'CounterController@show');
// Route::get('contacts', 'ContactController@index');
// Route::get('contact/{id}', 'ContactController@show');
// Route::get('settings', 'SettingController@index');
// Route::get('setting/{id}', 'SettingController@show');
// Route::get('portfolios', 'PortfolioController@index');
// Route::get('portfolio/{id}', 'PortfolioController@show');
// Route::get('pages', 'PageController@index');
// Route::get('page/{id}', 'PageController@show');
// Route::post('store/message', 'CMessageController@store');

// Route::post('store/newsletter', 'CNewsletterController@store');
Route::group(['middleware' => ['apiLocalization','cors']], function () {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/service/{id}', [ServiceController::class, 'show']);
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/testimonial/{id}', [TestimonialController::class, 'show']);
    Route::get('/processes', [ProcessController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::get('/process/{id}', [ProcessController::class, 'show']);

    Route::get('/faqs', [FaqController::class, 'index']);
    Route::get('/faq/{id}', [FaqController::class, 'show']);

    Route::get('/complains', [ComplainController::class, 'index']);
    Route::get('/complain/{id}', [ComplainController::class, 'show']);

    Route::get('/vaccancies',[VaccancyController::class,'index']);
    Route::get('/vaccancy/{id}',[VaccancyController::class,'show']);

    Route::get('/partners', [PartnerController::class, 'index']);
    Route::get('/partner/{id}', [PartnerController::class, 'show']);
    Route::get('/teams', [TeamController::class, 'index']);
    Route::get('/team/{id}', [TeamController::class, 'show']);

    Route::get('/partners', [PartnerController::class, 'index']);
    Route::get('/partner/{id}', [PartnerController::class, 'show']);

    Route::get('/counters', [CounterController::class, 'index']);
    Route::get('/counter/{id}', [CounterController::class, 'show']);
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/contact/{id}', [ContactController::class, 'show']);
    
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/historys', [HistoryController::class, 'index']);
    Route::get('/history/{id}', [HistoryController::class, 'show']);
    
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/project/{id}', [ProjectController::class, 'show']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/task/{id}', [TaskController::class, 'show']);
    Route::get('/pages', [PageController::class, 'index']);
    Route::get('/page/{id}', [PageController::class, 'show']);
    Route::get('/followups', [FollowupController::class, 'index']);
    Route::get('/followup/{id}', [FollowupController::class, 'show']);
    Route::get('/fees', [FeeController::class, 'index']);
    Route::get('/fee/{id}', [FeeController::class, 'show']);

    Route::get('/portfolios', [PortfolioController::class, 'index']);
    Route::get('/portfolio/{id}', [PortfolioController::class, 'show']);


});



Route::post('/newsletter', [NewsletterController::class, 'store']);
Route::post('/message', [MessageController::class, 'store']);

Route::post('/complain',[ComplainController::class,'store']);
Route::put('/complain/{id}',[ComplainController::class,'update']);
Route::delete('/complain/{id}',[ComplainController::class,'delete']);

Route::post('/vaccancy',[VaccancyController::class,'store']);
Route::put('/vaccancy/{id}',[VaccancyController::class,'update']);
Route::delete('/vaccancy/{id}',[VaccancyController::class,'delete']);

