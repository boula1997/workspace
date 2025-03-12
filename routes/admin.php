<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MessageController;
// use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ProcessController;
// use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ComplainController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\AccountantController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VaccancyController;
use App\Http\Controllers\Admin\FollowupController;
use App\Http\Controllers\Admin\FeeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteProductProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'name' => 'admin'
    ],
    function () {



        Route::group(['prefix' => 'dashboard'], function () {
            Auth::routes();
            // cancel login and register for front temporarly
            Route::get('/login', function () {
                return redirect()->route('admin.login-view');
            });

            Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])->name('admin.login-view');
            Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login')->middleware('guest:admin');
            Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showAdminRegisterForm'])->name('admin.register-view');
            Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'createAdmin'])->name('admin.register');
            Route::group(['middleware' => ['auth:admin']], function () {

                Route::get('/', function () {
                    return view('dashboard');
                })->name('dashboard');

            Route::resource('roles', RoleController::class);
            // Route::resource('home',HomeController::class);
            Route::resource('faqs', FaqController::class);
            // Route::resource('message',MessageController::class);
            Route::resource('services', ServiceController::class);
            // Route::resource('newsletter',NewsletterController::class);
            Route::resource('testimonials', TestimonialController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('processes', ProcessController::class);
            Route::resource('partners', PartnerController::class);
            Route::resource('teams', TeamController::class);
            Route::resource('products', ProductController::class);
            Route::resource('pages', PageController::class);
            Route::resource('partners', PartnerController::class);
            // Route::resource('about',AboutController::class);
            Route::resource('portfolios', PortfolioController::class);
            Route::resource('counters', CounterController::class);
            Route::resource('contacts', ContactController::class);
            Route::resource('videos', VideoController::class);
            Route::resource('tests', ImageController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('accountants', AccountantController::class);
            Route::resource('historys', HistoryController::class);
            Route::resource('users', UserController::class);
            Route::resource('projects', ProjectController::class);
            Route::resource('tasks', TaskController::class);
            Route::resource('admins', AdminController::class);
            Route::resource('messages', MessageController::class);
            Route::resource('complains', ComplainController::class);
            Route::resource('followups', FollowupController::class);
            Route::resource('fees', FeeController::class);
            Route::resource('vaccancies',VaccancyController::class);

            Route::get('/update-counter', [TaskController::class, 'updateCounter'])->name('counter.update');
            Route::get('level/toggle/{id}', [App\Http\Controllers\Admin\TaskController::class, 'toggleLevel'])->name('level.toggle');
            Route::get('piority/toggle/{id}', [App\Http\Controllers\Admin\TaskController::class, 'togglePiority'])->name('piority.toggle');

            Route::get('/finished/fees', [App\Http\Controllers\Admin\FeeController::class, 'index'])->name('fees.finished');

            Route::get('/get-active-websites', [TaskController::class, 'getActiveWebsites'])->name('active.websites');
            Route::get('/finished/followups', [App\Http\Controllers\Admin\FollowupController::class, 'index'])->name('followups.finished');
            Route::get('/all/followups', [App\Http\Controllers\Admin\FollowupController::class, 'index'])->name('followups.all');
            Route::get('/reply-message/{id}', [App\Http\Controllers\Admin\MessageController::class, 'reply'])->name('messages.reply');
            Route::get('/finished/tasks', [App\Http\Controllers\Admin\TaskController::class, 'index'])->name('tasks.finished');
            Route::get('/all/tasks', [App\Http\Controllers\Admin\TaskController::class, 'index'])->name('tasks.all');
            Route::post('/reply-email/{id}/reply', [App\Http\Controllers\Admin\MessageController::class, 'emailReply'])->name('messages.emailReply');
            Route::post('/tasks/changEmployees', [App\Http\Controllers\Admin\TaskController::class, 'taskChangeEmployee'])->name('tasks.changeEmployee');

            Route::post('/tasks/bulk-action', [TaskController::class, 'bulkAction'])->name('tasks.bulkAction');
           
            Route::post('/tasks/finish/delete', [App\Http\Controllers\Admin\TaskController::class, 'tasksDelete'])->name('tasks.finish');
            
            Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
            Route::post('/followups/changEmployees', [App\Http\Controllers\Admin\FollowupController::class, 'followupChangeEmployee'])->name('followups.changeEmployee');

            Route::post('/followups/bulk-action', [FollowupController::class, 'bulkAction'])->name('followups.bulkAction');
            Route::post('/date/system/filter', 'App\Http\Controllers\Admin\SettingController@filterDate')->name('date.filter');
           
            Route::post('/followups/finish/delete', [App\Http\Controllers\Admin\FollowupController::class, 'followupsDelete'])->name('followups.finish');
            Route::resource('newsletters', NewsletterController::class);

            Route::post('/fees/changEmployees', [App\Http\Controllers\Admin\FeeController::class, 'feeChangeEmployee'])->name('fees.changeEmployee');

            Route::post('/fees/bulk-action', [FeeController::class, 'bulkAction'])->name('fees.bulkAction');
           
            Route::post('/fees/finish/delete', [App\Http\Controllers\Admin\FeeController::class, 'feesDelete'])->name('fees.finish');

            Route::get('/reply-newsletter', [App\Http\Controllers\Admin\NewsletterController::class, 'reply'])->name('newsletters.reply');
            Route::post('/reply-email/reply', [App\Http\Controllers\Admin\NewsletterController::class, 'emailReply'])->name('newsletters.emailReply');
            Route::get('/dashboard', function () {
                return view('dashboard');
            });

            Route::put('/setting', 'App\Http\Controllers\Admin\SettingController@setting')->name('setting');
            Route::get('/setting/edit', 'App\Http\Controllers\Admin\SettingController@editSetting')->name('edit.setting');

            Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('update.profile');
            Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('edit.profile');

            Route::post('/tasks/update-keywords', [TaskController::class, 'updateKeywords'])->name('tasks.updateKeywords');
        });

        Route::get('/projects/public/{project}', [ProjectController::class, 'show'])->name('projects.publicShow');
    });
}
);
