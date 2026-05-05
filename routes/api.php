<?php

use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ActionController;
use App\Http\Controllers\API\GeneralController;
use App\Http\Controllers\API\CounterController;
use App\Http\Controllers\API\NewsletterController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\PortfolioController;
use App\Http\Controllers\API\FeeController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AccountantController;
use App\Http\Controllers\API\ClienttrackController;
use App\Http\Controllers\API\DatabaseController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\NavigationController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\ProcessController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\API\TrackController;
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


Route::group(['middleware' => ['apiLocalization','cors'],'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/track', [TaskController::class, 'track']);

Route::get('/deadlines/exceeded', function () {
    return response()->json([
        'exceeded' => hasExceededDeadlines()
    ]);
});

Route::get('/is/boula', function () {
    return response()->json([
        'isBoula' => boula()
    ]);
});









Route::post('/postFunction', [ActionController::class, 'postFunction']);

    Route::get('/clienttrack/{project_id}/{action}', [ClienttrackController::class, 'clienttrack']);
    Route::get('tracks/{id}', [TrackController::class, 'index']);

      if (App::environment('local')) {

    Route::post('/execute/query', [DatabaseController::class, 'execQuery'])->name('query.exec');
    Route::post('/save/query', [DatabaseController::class, 'saveQuery'])->name('query.save');
    Route::get('/get/queries/{id?}', [DatabaseController::class, 'getQueries'])->name('queries.get');
    Route::get('/get/commands/{id?}', [DatabaseController::class, 'getCommands'])->name('commands.get');

    Route::get('/get/searches/{id?}', [DatabaseController::class, 'getSearches'])->name('searches.get');
    Route::post('/save/search', [DatabaseController::class, 'saveSearch'])->name('search.save');
    Route::delete('/delete/search/{id}', [DatabaseController::class, 'deleteSearch'])->name('search.delete');
    Route::get('/databases/info/{dbname}/{namedb}', [DatabaseController::class, 'getDatabase']);
    }else{
    Route::middleware('auth:admin-api','apiLocalization','cors')->group(function () {
    Route::post('/execute/query', [DatabaseController::class, 'execQuery'])->name('query.exec');
    Route::post('/save/query', [DatabaseController::class, 'saveQuery'])->name('query.save');
    Route::get('/get/queries/{id?}', [DatabaseController::class, 'getQueries'])->name('queries.get');
    Route::get('/get/commands/{id?}', [DatabaseController::class, 'getCommands'])->name('commands.get');
    Route::post('/save/search', [DatabaseController::class, 'saveSearch'])->name('search.save');
    Route::get('/get/searches/{id?}', [DatabaseController::class, 'getSearches'])->name('searches.get');
    Route::delete('/delete/search/{id}', [DatabaseController::class, 'deleteSearch'])->name('search.delete');
    Route::get('/databases/info/{dbname}/{namedb}', [DatabaseController::class, 'getDatabase']);
          });

      }



    Route::middleware('auth:admin-api','apiLocalization','cors')->group(function () {

    Route::resource('complains', ComplainController::class);



    Route::get('/showEditCreate/{dbname}/{table}/{itemId}', [GeneralController::class, 'showEditCreate']);
    Route::post('/storeUpdate/{dbname}/{table}/{itemId}', [GeneralController::class, 'storeUpdate']);
    Route::post('/blocktables/{dbname}', [GeneralController::class, 'blockTables']);
    Route::get('/deleteItem/{dbname}/{table}/{itemId}', [GeneralController::class, 'deleteItem']);
    Route::get('/index/{dbname}/{table}/{column?}/{equal?}', [GeneralController::class, 'index']);
    Route::get('/tables/{dbname}', [GeneralController::class, 'tableNames']);
    Route::get('/all/tables/{dbname}/{admin_id?}', [GeneralController::class, 'allTableNames']);
    Route::get('/databases', [GeneralController::class, 'databases']);
    Route::get('/bases', [TaskController::class, 'bases']);
    Route::get('/admins/{dbname}', [GeneralController::class, 'getAdmins']);
    Route::get('/input/appearances/{dbname}', [GeneralController::class, 'getInputAppearances']);


    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/updateDeadline',[TaskController::class,'updateDeadline']);
    Route::post('/updatedSelectedDeadlines',[TaskController::class,'updatedSelectedDeadlines']);
    Route::post('/updateSetting',[SettingController::class,'update']);
    Route::post('/updateProjectDeadline',[TaskController::class,'updateProjectDeadline']);
    Route::post('/storeDeadline',[TaskController::class,'storeDeadline']);
    Route::get('/stats', [TaskController::class, 'stats']);
    Route::get('/links/category/{id}', [TaskController::class, 'links'])->name('links');
    Route::get('/elements/category/{id}', [TaskController::class, 'elements'])->name('elements');
    Route::get('/last/{date}', 'App\Http\Controllers\ActionController@lastUpdate')->name('last.update');
    Route::get('/issue/hollyMass', [TaskController::class, 'hollyMass'])->name('hollyMass.issue');
    Route::get('/issue/facebookAds', [TaskController::class, 'facebookAds'])->name('facebookAds.issue');
    Route::get('/deadlines', [TaskController::class, 'deadlines'])->name('deadlines');
    Route::get('/apptask/create', [TaskController::class, 'create']);
    Route::get('/board/projects', [TaskController::class, 'boardProjects']);
    Route::get('/data/info', [TaskController::class, 'info']);
    Route::get('/apptask/tasks', [TaskController::class, 'tasks']);
    Route::get('/offline/tasks', [TaskController::class, 'offlineTasks']);
    Route::get('/offline/notes', [TaskController::class, 'offlineNotes']);
    Route::get('/competitors', [TaskController::class, 'competitors']);
    Route::get('/marketing-tools', [TaskController::class, 'marketingTools']);
    Route::get('/settings', [TaskController::class, 'settings']);
    Route::get('/apptask/finished/tasks', [TaskController::class, 'finishedTasks']);
    Route::get('/note', [TaskController::class, 'lifNote'])->name('life.note');
    Route::get('/apptask/create/finished', [TaskController::class, 'createFinished']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/getFunction', [ActionController::class, 'getFunction']);
    Route::post('/apptask/refproPost', [TaskController::class, 'refproPost']);
    Route::post('/apptask/refproGet', [TaskController::class, 'refproGet']);
    Route::post('/apptask/store', [TaskController::class, 'store']);
    Route::get('deleteTask/{id}', [TaskController::class, 'toggleStatus'])->name('status.toggle');
    Route::middleware('businessHours')->group(function () {
    Route::get('piority/toggle/{id}', [TaskController::class, 'togglePiority'])->name('piority.toggle');
    Route::get('/lock', [TaskController::class, 'lock'])->name('lock');
    Route::get('/lastRepeatTime', [TaskController::class, 'lastRepeatTime'])->name('lastRepeatTime');
    Route::post('/createLastRepeatTime', [TaskController::class, 'createLastRepeatTime'])->name('createLastRepeatTime');
    Route::post('/apptask/bulk-delete', [TaskController::class, 'bulkDelete']);
    Route::post('/apptask/bulk-assign', [TaskController::class, 'bulkAssign']);
    Route::post('apptask/bulk-assign-project', [TaskController::class, 'bulkAssignProject']);
    Route::post('/apptask/bulk-update-date', [TaskController::class, 'bulkUpdateDate']);
    Route::post('/marketing/create-post', [TaskController::class, 'createPost']);
    Route::get('/marketing/get-posts', [TaskController::class, 'getPosts']);
    Route::delete('/marketing/delete-post/{id}', [TaskController::class, 'deletePost']);
    Route::post('/add/project/hours', [TaskController::class, 'addProjectHours']);
    Route::post('/add/phone/gig', [TaskController::class, 'addPhoneGig']);
    Route::post('/add/post/gig', [TaskController::class, 'addPostGig']);
    Route::post('/add/call/history', [TaskController::class, 'addCallHistory']);
    Route::get('/get/all/phone/gigs', [TaskController::class, 'getAllPhoneGigs']);
    Route::get('/get/all/post/gigs', [TaskController::class, 'getAllPostGigs']);
    Route::post('/update/tasks/to/today', [TaskController::class, 'updateTasksToToday']);
});
}); 
