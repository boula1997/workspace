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
use App\Http\Controllers\API\AccountantController;
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
use App\Http\Controllers\AuthController;

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


Route::group(['middleware' => ['apiLocalization','cors']], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});












Route::middleware('auth:admin-api')->group(function () {
    
    Route::get('/stats', [TaskController::class, 'stats']);
    Route::get('/links', [TaskController::class, 'links'])->name('links');
    Route::get('/last/{date}', 'App\Http\Controllers\ActionController@lastUpdate')->name('last.update');
    Route::get('/deadlines', [TaskController::class, 'deadlines'])->name('deadlines');
    Route::post('/updateDeadline',[TaskController::class,'updateDeadline']);
    Route::get('/apptask/create', [TaskController::class, 'create']);
    Route::get('/apptask/create/finished', [TaskController::class, 'createFinished']);

    Route::middleware('businessHours')->group(function () {
    Route::get('deleteTask/{id}', [TaskController::class, 'toggleStatus'])->name('status.toggle');
    Route::get('piority/toggle/{id}', [TaskController::class, 'togglePiority'])->name('piority.toggle');
    Route::post('/apptask/store', [TaskController::class, 'store']);
    Route::post('/apptask/refpro', [TaskController::class, 'refpro']);
});


});


