<?php

use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ActionController;
use App\Http\Controllers\API\GeneralController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
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
use App\Http\Controllers\API\FileSearchController;
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
// New focused controllers extracted from TaskController
use App\Http\Controllers\API\DeadlineController;
use App\Http\Controllers\API\MarketingController;
use App\Http\Controllers\API\GigController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\IssueController;
use App\Http\Controllers\API\MiscController;

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


Route::group(['middleware' => ['apiLocalization', 'cors'], 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/track', [MiscController::class, 'track']);

Route::post('/async/create', [TaskController::class, 'asyncCreate']);

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
    Route::get('/databases/suggest/{dbname}/{namedb}', [DatabaseController::class, 'suggestSchema']);
    Route::get('/databases/skipped-tables/{id}', [DatabaseController::class, 'getSkippedTables']);
    Route::post('/databases/skipped-tables/{id}', [DatabaseController::class, 'updateSkippedTables']);
    Route::post('/matching/queries', [DatabaseController::class, 'queryMatching']);
} else {
    Route::middleware('auth:admin-api', 'apiLocalization', 'cors')->group(function () {
        Route::post('/execute/query', [DatabaseController::class, 'execQuery'])->name('query.exec');
        Route::post('/save/query', [DatabaseController::class, 'saveQuery'])->name('query.save');
        Route::get('/get/queries/{id?}', [DatabaseController::class, 'getQueries'])->name('queries.get');
        Route::get('/get/commands/{id?}', [DatabaseController::class, 'getCommands'])->name('commands.get');
        Route::post('/save/search', [DatabaseController::class, 'saveSearch'])->name('search.save');
        Route::get('/get/searches/{id?}', [DatabaseController::class, 'getSearches'])->name('searches.get');
        Route::delete('/delete/search/{id}', [DatabaseController::class, 'deleteSearch'])->name('search.delete');
        Route::get('/databases/info/{dbname}/{namedb}', [DatabaseController::class, 'getDatabase']);
        Route::get('/databases/suggest/{dbname}/{namedb}', [DatabaseController::class, 'suggestSchema']);
        Route::get('/databases/skipped-tables/{id}', [DatabaseController::class, 'getSkippedTables']);
        Route::post('/databases/skipped-tables/{id}', [DatabaseController::class, 'updateSkippedTables']);
        Route::post('/matching/queries', [DatabaseController::class, 'queryMatching']);
    });
}

Route::post('/differences', [DatabaseController::class, 'storeDifference']);
Route::get('/differences', [DatabaseController::class, 'getDifferences']);

Route::get('/client/tasks', [TaskController::class, 'clientTasks']);
Route::post('/client/tasks/store', [TaskController::class, 'clientTaskStore']);

Route::prefix('file')->group(function () {
    Route::post('/read-content', [FileSearchController::class, 'readContent']);
    Route::post('/count-occurrences', [FileSearchController::class, 'countOccurrences']);
});

Route::get('deleteTask/{id}', [TaskController::class, 'toggleStatus'])->name('status.toggle');

Route::middleware('auth:admin-api', 'apiLocalization', 'cors')->group(function () {

    Route::resource('complains', ComplainController::class);
    Route::apiResource('kit_tools', \App\Http\Controllers\API\KitToolController::class);

    Route::get('/showEditCreate/{dbname}/{table}/{itemId}', [GeneralController::class, 'showEditCreate']);
    Route::post('/storeUpdate/{dbname}/{table}/{itemId}', [GeneralController::class, 'storeUpdate']);
    Route::post('/blocktables/{dbname}', [GeneralController::class, 'blockTables']);
    Route::get('/deleteItem/{dbname}/{table}/{itemId}', [GeneralController::class, 'deleteItem']);
    Route::get('/index/{dbname}/{table}/{column?}/{equal?}', [GeneralController::class, 'index']);
    Route::get('/tables/{dbname}', [GeneralController::class, 'tableNames']);
    Route::get('/all/tables/{dbname}/{admin_id?}', [GeneralController::class, 'allTableNames']);
    Route::get('/databases', [GeneralController::class, 'databases']);
    Route::get('/bases', [MiscController::class, 'bases']);
    Route::get('/all/admins/{dbname}', [GeneralController::class, 'getAdmins']);
    Route::get('/input/appearances/{dbname}', [GeneralController::class, 'getInputAppearances']);
    Route::get('/menu/tables/{dbname}', [GeneralController::class, 'menuTables']);

    Route::get('/categories', [CategoryController::class, 'index']);

    // Deadlines
    Route::post('/updateDeadline', [DeadlineController::class, 'update']);
    Route::post('/updatedSelectedDeadlines', [DeadlineController::class, 'bulkUpdateDate']);
    Route::post('/updateProjectDeadline', [DeadlineController::class, 'updateProjectDeadline']);
    Route::post('/storeDeadline', [DeadlineController::class, 'store']);
    Route::get('/deadlines', [DeadlineController::class, 'index'])->name('deadlines');

    // Settings
    Route::post('/updateSetting', [SettingController::class, 'update']);

    // Dashboard / Stats
    Route::get('/stats', [DashboardController::class, 'stats']);
    Route::get('/board/projects', [DashboardController::class, 'boardProjects']);
    Route::get('/data/info', [DashboardController::class, 'info']);
    Route::get('/offline/info', [DashboardController::class, 'offlineInfo']);
    Route::post('async/offline/info', [DashboardController::class, 'asyncOfflineInfo']);

    // Navigation / Links
    Route::get('/links', [NavigationController::class, 'links'])->name('links');
    Route::put('/links/{id}/extra', [NavigationController::class, 'updateExtra']);

    // Dynamic category elements
    Route::get('/elements/category/{id}', [MiscController::class, 'elements'])->name('elements');

    // Issues
    Route::get('/issue/hollyMass', [IssueController::class, 'hollyMass'])->name('hollyMass.issue');
    Route::get('/issue/facebookAds', [IssueController::class, 'facebookAds'])->name('facebookAds.issue');
    Route::post('/apptask/refproPost', [IssueController::class, 'refproPost']);
    Route::post('/apptask/refproGet', [IssueController::class, 'refproGet']);

    // Tasks
    Route::get('/apptask/create', [TaskController::class, 'create']);
    Route::get('/apptask/tasks', [TaskController::class, 'tasks']);
    Route::get('/offline/tasks', [TaskController::class, 'offlineTasks']);
    Route::get('/apptask/create/finished', [TaskController::class, 'createFinished']);
    Route::get('/apptask/finished/tasks', [TaskController::class, 'finishedTasks']);
    Route::post('/apptask/store', [TaskController::class, 'store']);
    Route::post('apptask/update-task/{id}', [TaskController::class, 'updateTaskTitleAndComments']);
    Route::get('apptask/by-credential/{db_credential_id}', [TaskController::class, 'tasksByCredential']);

    // Misc
    Route::get('/last/{date}', 'App\Http\Controllers\ActionController@lastUpdate')->name('last.update');
    Route::get('/offline/notes', [MiscController::class, 'offlineNotes']);
    Route::get('/settings', [MiscController::class, 'settings']);
    Route::get('/note', [MiscController::class, 'offlineNotes'])->name('life.note');

    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/getFunction', [ActionController::class, 'getFunction']);

    Route::middleware('businessHours')->group(function () {
        Route::get('piority/toggle/{id}', [TaskController::class, 'togglePiority'])->name('piority.toggle');
        Route::get('/lock', [DashboardController::class, 'lock'])->name('lock');
        Route::get('/lastRepeatTime', [MiscController::class, 'lastRepeatTime'])->name('lastRepeatTime');
        Route::post('/createLastRepeatTime', [MiscController::class, 'createLastRepeatTime'])->name('createLastRepeatTime');
        Route::post('/apptask/bulk-delete', [TaskController::class, 'bulkDelete']);
        Route::post('/apptask/bulk-assign', [TaskController::class, 'bulkAssign']);
        Route::post('apptask/bulk-assign-project', [TaskController::class, 'bulkAssignProject']);
        Route::post('/apptask/bulk-update-date', [TaskController::class, 'bulkUpdateDate']);
        Route::post('/update/tasks/to/today', [TaskController::class, 'updateTasksToToday']);

        // Marketing
        Route::post('/marketing/create-post', [MarketingController::class, 'createPost']);
        Route::get('/marketing/get-posts', [MarketingController::class, 'getPosts']);
        Route::delete('/marketing/delete-post/{id}', [MarketingController::class, 'deletePost']);
        Route::get('/marketing/get-ready-response-messages', [MiscController::class, 'getReadyResponseMessages']);
        Route::get('/competitors', [MarketingController::class, 'competitors']);
        Route::get('/jobs', [MarketingController::class, 'jobs']);
        Route::get('/marketing-tools', [MarketingController::class, 'marketingTools']);

        // Project hours
        Route::post('/add/project/hours', [MiscController::class, 'addProjectHours']);

        // Gigs
        Route::post('/add/phone/gig', [GigController::class, 'addPhoneGig']);
        Route::post('/add/post/gig', [GigController::class, 'addPostGig']);
        Route::post('/add/call/history', [GigController::class, 'addCallHistory']);
        Route::post('/add/link/history', [GigController::class, 'addLinkHistory']);
        Route::get('/get/all/phone/gigs', [GigController::class, 'getAllPhoneGigs']);
        Route::get('/get/all/post/gigs', [GigController::class, 'getAllPostGigs']);
        Route::delete('phone-gig/{id}', [GigController::class, 'deletePhoneGig']);
        Route::delete('post-gig/{id}', [GigController::class, 'deletePostGig']);

        // Surveys & repeat
        Route::get('/surveies', [MiscController::class, 'surveies']);
        Route::get('/get/repeat/survey/minuits', [MiscController::class, 'getRepeatSurveyMinuits']);
    });

    Route::resource('admins', AdminController::class);
    Route::resource('roles', RoleController::class);
    Route::get('all/roles', [RoleController::class, 'all_roles']);
    Route::resource('users', UserController::class);
    Route::get('all/permissions', [RoleController::class, 'all_permissions']);
});
