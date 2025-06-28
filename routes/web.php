<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SqlQueryController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MessageController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\LocalActionController;
use Illuminate\Support\Facades\URL;

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

if (true) { Route::get('routes', function () { $routeCollection = Route::getRoutes(); echo "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>"; echo "<tr>"; echo "<th style='border: 1px solid black;'>HTTP Method</th>"; echo "<th style='border: 1px solid black;'>Route</th>"; echo "<th style='border: 1px solid black;'>Name</th>"; echo "<th style='border: 1px solid black;'>Corresponding Action</th>"; echo "</tr>"; foreach ($routeCollection as $value) { echo "<tr>"; echo "<td style='border: 1px solid black;'>" . $value->methods()[0] . "</td>"; echo "<td style='border: 1px solid black;'>" . $value->uri() . "</td>"; echo "<td style='border: 1px solid black;'>" . ($value->getName() ?? 'N/A') . "</td>"; echo "<td style='border: 1px solid black;'>" . $value->getActionName() . "</td>"; echo "</tr>"; } echo "</table>"; }); }


Route::group(['middleware' => ['auth:admin']], function () {
    Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
            'name' => 'admin'
        ],
        function () {
    
    
            Route::get('/', [HomeController::class, 'index'])->name('action');
            Route::get('/videos', [HomeController::class, 'videos'])->name('videos');
            Route::get('/faq-page', 'App/Http/Controllers/FaqController@index')->name('front.faq');
            // Route::get('/message', 'App/Http/Controllers/MessageController@index')->name('front.message');
            Route::get('/message', [MessageController::class,'index'])->name('front.message');
            // Route::get('/service', 'App/Http/Controllers/ServiceController@index')->name('front.service');
            // Route::get('/newsletter', 'App/Http/Controllers/NewsletterController@index')->name('front.newsletter');
            Route::get('/newsletter', [NewsletterController::class,'index'])->name('front.newsletter');
    
            Route::get('/service', [ServiceController::class,'index'])->name('front.service');
            
            // Route::get('/single-service', 'App/Http/Controllers/ServiceController@show')->name('front.show.service');
           
            Route::get('/single-service/{id}', [ServiceController::class,'show'])->name('front.show.service');
           
           
            Route::get('/testimonial', 'App/Http/Controllers/TestimonialController@index')->name('front.testimonial');
            Route::get('/single-testimonial', 'App/Http/Controllers/TestimonialController@show')->name('front.show.testimonial');
            Route::get('/process', 'App/Http/Controllers/ProcessController@index')->name('front.process');
            Route::get('/single-process', 'App/Http/Controllers/ProcessController@show')->name('front.show.process');
            Route::get('/single-faq', 'App/Http/Controllers/FaqController@show')->name('front.show.faq');
    
            Route::get('/portfolios', [PortfolioController::class,'index'])->name('front.portfolios');
            Route::get('/portfolio/{id}', [PortfolioController::class,'show'])->name('front.show.portfolio');
            Route::get('/video', 'App/Http/Controllers/VideoController@index')->name('front.video');
            // Route::get('/about', 'App/Http/Controllers/AboutController@index')->name('front.about');
            Route::get('/about', [AboutController::class,'index'])->name('front.about');
            // Route::post('/message', 'App/Http/Controllers/MessageController@store')->name('front.message.post');
            Route::post('/message', [MessageController::class,'store'])->name('front.message.post');
    
            Route::get('/single-portfolio/{id}', [ServiceController::class,'showportfolio'])->name('front.show.portfolio');
            // Route::post('/newsletter', 'App/Http/Controllers/NewsletterController@store')->name('front.newsletter.post');
            Route::post('/newsletter', [NewsletterController::class,'store'])->name('front.newsletter.post');
    
            // Route::get('/reply', function () {
    
            //     return view("mail.replymessage");
            // });
    
    
            Route::get('/run-query', [SqlQueryController::class, 'runQuery']);
    
    
    
    
    
    Route::get('/', function () {
        $action="";
        return view('welcome',compact('action'));
    })->name('action');
    Route::get('/accountant', function () {
        $action="";
        return view('accountant');
    })->name('accountant');
    Route::get('/db/credentials', function () {
        $action="";
        return view('dbcredentials');
    })->name('accountant');
    Route::get('/accountantMotahda', function () {
        $action="";
        return view('accountantMotahda');
    })->name('accountant.motahda');
    Route::get('/notes', function () {
        $action="";
        return view('accountant');
    })->name('notes');
    Route::get('/second', function () {
        $action="";
        return view('accountantBoula');
    })->name('accountant.boula');
    Route::get('/issues', function () {
        $action="";
        return view('issues');
    })->name('issue');
    Route::get('/servers', function () {
        $action="";
        return view('serversData');
    })->name('server');
    
    
    Route::get('/auto', function () {
        $action="auto";
        return view('auto');
    })->name('auto');
    
    Route::get('/accountant/filter', function () {
        $action="";
        return view('accountant');
    })->name('accountantFilter');
    Route::get('/secound/filter', function () {
        $action="";
        return view('accountantBoula');
    })->name('secondFilter');


    if (App::environment('local')) {
        Route::resource('actions', LocalActionController::class);

        Route::post('/postAction', 'App\Http\Controllers\LocalActionController@store')->name('post.action');
        
        Route::get('/data/{db}/{table}/{query}', 'App\Http\Controllers\LocalActionController@show')->name('db.data');
        Route::get('/last/{date}', 'App\Http\Controllers\LocalActionController@lastUpdate')->name('last.update');
        Route::get('/website/{id}', 'App\Http\Controllers\LocalActionController@websiteToggle')->name('website.toggle');
        
        Route::get('/websitedbl/{id}', 'App\Http\Controllers\LocalActionController@websiteToggle')->name('website.dbltoggle');
        Route::get('/websitetrpl/{id}', 'App\Http\Controllers\LocalActionController@websiteToggle')->name('website.trpltoggle');
        
        Route::post('/execute/query', 'App\Http\Controllers\LocalActionController@execQuery')->name('query.exec');
        Route::post('/filterStats', 'App\Http\Controllers\LocalActionController@filterStats')->name('filterStats');
        
        Route::post('/upload/images', 'App\Http\Controllers\LocalActionController@uploadImages')->name('upload.images');
        
        Route::post('/update/sample/script', 'App\Http\Controllers\LocalActionController@updateSamples')->name('samples.script');
    
        Route::post('/update/post/tasks', 'App\Http\Controllers\LocalActionController@updatePosts')->name('posts.tasks');
    
        Route::post('/update/reference/tasks', 'App\Http\Controllers\LocalActionController@updateReferences')->name('references.tasks');
        Route::post('/update/welcome/tasks', 'App\Http\Controllers\LocalActionController@updateTasks')->name('updateTasks');

        Route::post('/get-table-columns', [LocalActionController::class, 'getTableColumns'])->name('getTableColumns');
        
        
        Route::post('/update/boula/tasks', 'App\Http\Controllers\LocalActionController@updateBoulas')->name('boulas.tasks');
        Route::post('/issues', 'App\Http\Controllers\LocalActionController@issueUpdate')->name('issues.update');



        Route::post('/servers', 'App\Http\Controllers\LocalActionController@serverUpdate')->name('servers.update');
        
        Route::delete('/delete/scripts/{id}', 'App\Http\Controllers\LocalActionController@destroy')->name('delete.scripts');
        Route::delete('/remove/projects/{id}', 'App\Http\Controllers\LocalActionController@destroy')->name('remove.projects');
        
        Route::get('/websites', 'App\Http\Controllers\LocalActionController@websitesImportant')->name('websites.important');
        Route::get('/tasks/important', 'App\Http\Controllers\LocalActionController@tasksImportant')->name('tasks.important');
        
        Route::post('/clicks', 'App\Http\Controllers\LocalActionController@createClickTime')->name('times.create');
        
        
        Route::post('/logout', 'App\Http\Controllers\LocalActionController@createClickTime')->name('logout');
        
        
        Route::post('/store-datetime', 'App\Http\Controllers\LocalActionController@createStartTime')->name('store.datetime');
        
        Route::post('/reset-datetime', 'App\Http\Controllers\LocalActionController@createStartTime')->name('reset.datetime');
        Route::post('/update-datetime', 'App\Http\Controllers\LocalActionController@updateStartTime')->name('update.datetime');
        
        Route::get('/post/deal/{id}', 'App\Http\Controllers\LocalActionController@toggleDealPost')->name('post.deal');
        Route::get('/post/show/{id}', 'App\Http\Controllers\LocalActionController@toggleShowPost')->name('post.show');
        
        Route::get('/boula/deal/{id}', 'App\Http\Controllers\LocalActionController@toggleDealBoula')->name('boula.deal');
        Route::get('/server/toggle/{id}', 'App\Http\Controllers\LocalActionController@toggleCommited')->name('toggleCommited');
        Route::get('/server/active/{id}', 'App\Http\Controllers\LocalActionController@toggleactive')->name('toggleactive');
        Route::get('/server/ask/{id}', 'App\Http\Controllers\LocalActionController@toggleask')->name('toggleask');
        Route::get('/server/auto/{id}', 'App\Http\Controllers\LocalActionController@toggleauto')->name('toggleauto');
        
        Route::post('/cycle-employee', [LocalActionController::class, 'cycleEmployee'])->name('cycle-employee');
        
        
        Route::get('/active-websites-titles', function() {
            return response()->json(activeWebsitesTitle());
        });
        
        Route::get('/templates', [LocalActionController::class, 'templates'])->name('templates');
        Route::get('/googleads', [LocalActionController::class, 'googleads'])->name('googleads');
    }
     else {
        Route::resource('actions', ActionController::class);
                Route::post('/postAction', 'App\Http\Controllers\ActionController@store')->name('post.action');
        
        Route::get('/data/{db}/{table}/{query}', 'App\Http\Controllers\ActionController@show')->name('db.data');
        Route::get('/last/{date}', 'App\Http\Controllers\ActionController@lastUpdate')->name('last.update');
        Route::get('/website/{id}', 'App\Http\Controllers\ActionController@websiteToggle')->name('website.toggle');
        
        Route::get('/websitedbl/{id}', 'App\Http\Controllers\ActionController@websiteToggle')->name('website.dbltoggle');
        Route::get('/websitetrpl/{id}', 'App\Http\Controllers\ActionController@websiteToggle')->name('website.trpltoggle');
        
        Route::post('/execute/query', 'App\Http\Controllers\ActionController@execQuery')->name('query.exec');
        Route::post('/filterStats', 'App\Http\Controllers\ActionController@filterStats')->name('filterStats');
        
        Route::post('/upload/images', 'App\Http\Controllers\ActionController@uploadImages')->name('upload.images');
        
            Route::post('/update/sample/script', 'App\Http\Controllers\ActionController@updateSamples')->name('samples.script');
        Route::post('/update/post/tasks', 'App\Http\Controllers\ActionController@updatePosts')->name('posts.tasks');
        Route::post('/update/welcome/tasks', 'App\Http\Controllers\ActionController@updateTasks')->name('updateTasks');

        Route::post('/get-table-columns', [ActionController::class, 'getTableColumns'])->name('getTableColumns');
    
        Route::post('/update/reference/tasks', 'App\Http\Controllers\ActionController@updateReferences')->name('references.tasks');
        
        
        Route::post('/update/boula/tasks', 'App\Http\Controllers\ActionController@updateBoulas')->name('boulas.tasks');
        Route::post('/issues', 'App\Http\Controllers\ActionController@issueUpdate')->name('issues.update');
        
        Route::post('/servers', 'App\Http\Controllers\ActionController@serverUpdate')->name('servers.update');
        
        Route::delete('/delete/scripts/{id}', 'App\Http\Controllers\ActionController@destroy')->name('delete.scripts');
        Route::delete('/remove/projects/{id}', 'App\Http\Controllers\ActionController@destroy')->name('remove.projects');
        
        Route::get('/websites', 'App\Http\Controllers\ActionController@websitesImportant')->name('websites.important');
        
        Route::get('/tasks/important', 'App\Http\Controllers\ActionController@tasksImportant')->name('tasks.important');
        
        Route::post('/clicks', 'App\Http\Controllers\ActionController@createClickTime')->name('times.create');
        
        
        Route::post('/logout', 'App\Http\Controllers\ActionController@createClickTime')->name('logout');
        
        
        Route::post('/store-datetime', 'App\Http\Controllers\ActionController@createStartTime')->name('store.datetime');
        
        Route::post('/reset-datetime', 'App\Http\Controllers\ActionController@createStartTime')->name('reset.datetime');
        Route::post('/update-datetime', 'App\Http\Controllers\ActionController@updateStartTime')->name('update.datetime');
        
        Route::get('/post/deal/{id}', 'App\Http\Controllers\ActionController@toggleDealPost')->name('post.deal');
        Route::get('/post/show/{id}', 'App\Http\Controllers\ActionController@toggleShowPost')->name('post.show');
        
        Route::get('/boula/deal/{id}', 'App\Http\Controllers\ActionController@toggleDealBoula')->name('boula.deal');
        Route::get('/server/toggle/{id}', 'App\Http\Controllers\ActionController@toggleCommited')->name('toggleCommited');
        Route::get('/server/active/{id}', 'App\Http\Controllers\ActionController@toggleactive')->name('toggleactive');
        Route::get('/server/ask/{id}', 'App\Http\Controllers\ActionController@toggleask')->name('toggleask');
        Route::get('/server/auto/{id}', 'App\Http\Controllers\ActionController@toggleauto')->name('toggleauto');
        
        Route::post('/cycle-employee', [ActionController::class, 'cycleEmployee'])->name('cycle-employee');
        
        
        Route::get('/active-websites-titles', function() {
            return response()->json(activeWebsitesTitle());
        });
        
        Route::get('/templates', [ActionController::class, 'templates'])->name('templates');
        Route::get('/googleads', [ActionController::class, 'googleads'])->name('googleads');
    }
    
    
        }
    );
    

});






