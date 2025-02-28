<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Complain;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Issue;
use App\Models\Message;
use App\Models\Counter;
use App\Models\Newsletter;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Followup;
use App\Models\Image;
use App\Models\Accountant;
use App\Models\History;
use App\Models\Project;
use App\Models\Page;
use App\Models\Team;
use App\Models\Deadline;
use App\Models\Task;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\Process;
use App\Models\Service;
use App\Models\Fee;
use App\Models\Setting;
use App\Models\User;
use App\Models\Product;
use App\Models\Vaccancy;
use App\Models\Video;
use App\Models\Sample;
use Illuminate\Support\Facades\File;
use Jackiedo\Cart\Facades\Cart;
use Spatie\Permission\Models\Role;
use App\Services\MailService;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\LocalActionController;
use App\Livewire\Posts;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Controllers\SqlQueryController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Scopes\DateFilterScope;



const Newsletter_Mail = "app@gmail.com";
function settings()
{
    return Setting::first();
}


function clearTasks($taskTitle)
{
    // Fetch tasks with the given title
    $tasks = Task::where('title', $taskTitle)->get();

    // Group tasks by employee_id
    $groupedTasks = $tasks->groupBy('employee_id');

    foreach ($groupedTasks as $employeeId => $employeeTasks) {
        // Filter tasks by status
        $status1Tasks = $employeeTasks->where('status', 1);
        $otherStatusTasks = $employeeTasks->where('status', '!=', 1);

        // If there are both status 1 tasks and other status tasks for the same employee
        if ($status1Tasks->isNotEmpty() && $otherStatusTasks->isNotEmpty()) {
            // Delete tasks with status 1
            Task::whereIn('id', $status1Tasks->pluck('id'))->delete();
        }
    }
}


function activeDeadline()
{
    // Get the closest deadline that is today or in the future
    $deadline = Deadline::where('date', '>=', now()->toDateString())
                        ->orderBy('date', 'asc')
                        ->first();

    return [
        'deadline' => $deadline ? $deadline->date : now()->toDateString(),
        'action' => $deadline ? $deadline->title : "No action to do", // No action if no deadline exists
    ];
}


function taskLog($action,$task_title){

    $task=Task::where('title',$task_title)->where('employee_id',auth()->user()->id)->first();
    if(!isset($task)){
        return redirect()->back()->with(['error' => __('general.you_are_not_allowed_to_do_this_assignit_to_you_first')]);
    }
    if($task->status==1){

        History::create([
            'action'=>$action,
            'task_id'=>$task->id,
            'employee_id'=>auth()->user()->id,
        ]);


        $to = "nessimboula@gmail.com";
        $toName = "Boula Nessim";
        $subject = 'History: '.auth()->user()->email;
        $body = auth('admin')->user()->name.' has finsished '.$task_title;

        // Call the MailService to send the email
        $result = MailService::sendMail($to, $toName, $subject, $body);
    }
    else{
        $tasks=Task::where('title',$task_title)->get();
        foreach($tasks as $task){
            if($task->status==0)
            History::where('task_id',$task->id)->delete();
        }
    }


}

function dectatorBoula(){
    // Check if the user is authenticated before accessing their email
    if(!boula())
    if (in_array(request()->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
        abort(403, 'Action not allowed');
    }
}

function notAllowedTaskAction($taskTitle){
    $taskIds = Task::where('title', $taskTitle)->pluck('employee_id')->toArray();  // Convert to array
    if (!in_array(auth()->user()->id, $taskIds)) {
        return redirect()->back()->with(['error' => __('general.you_are_not_allowed_to_do_this_assignit_to_you_first')]);
    }
}

function received($admin){
    $received=Accountant::where('employee_id',$admin->id)->sum('received');
    if(isset($received) && (auth()->user()->email==$admin->email || boula()))
     return $received;
    else
    return 'None';
}
function has($admin){
    $has=Accountant::where('employee_id',$admin->id)->sum('has');
    if(isset($has) && (auth()->user()->email==$admin->email || boula()))
     return $has;
    else
    return 'None';
}
function emailTasks()
{
    $admins = Admin::get();
    foreach ($admins as $admin) {
        // Email details
        $to = $admin->email;
        $toName = "Boula Nessim";
        $subject = 'Tasks Report';

        // Get important tasks (High Priority)
        $importantTasks = Task::withoutGlobalScope(DateFilterScope::class)
                              ->where('status', 0)
                              ->where('piority', 1) // High priority tasks
                              ->orderBy('project_id', 'desc')
                              ->get()
                              ->unique('title');

        // Get all tasks
        $tasks = Task::withoutGlobalScope(DateFilterScope::class)
                     ->where('status', 0)
                     ->orderBy('project_id', 'desc')
                     ->get()
                     ->unique('title');

        // Construct the email content
        $body = '<html lang="en"><head><meta charset="UTF-8"><title>Tasks Report</title></head><body>';
        $body .= '<h1>Tasks Report</h1>';

        // **Important Tasks Table (Placed at the Top)**
        if ($importantTasks->isNotEmpty()) {
            $body .= '<h2 style="color:red;">⚠️ Important Tasks</h2>';
            $body .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
            $body .= '<thead><tr><th>Task</th><th>Project</th><th>Priority</th></tr></thead><tbody>';

            foreach ($importantTasks as $task) {
                $body .= '<tr>';
                $body .= '<td>' . htmlspecialchars($task->title, ENT_QUOTES, 'UTF-8') . '</td>';
                $body .= '<td>' . htmlspecialchars($task->project->title ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
                $body .= '<td style="color:red; font-weight:bold;">High</td>';
                $body .= '</tr>';
            }

            $body .= '</tbody></table><br>'; // Add space after the table
        }

        // **All Tasks Table**
        $body .= '<h2>All Tasks</h2>';
        $body .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
        $body .= '<thead><tr><th>Task</th><th>Project</th><th>Difficulty</th></tr></thead><tbody>';

        foreach ($tasks as $task) {
            $difficulty = $task->level == 1 ? 'Mobile' : 'PC';
            $body .= '<tr>';
            $body .= '<td>' . htmlspecialchars($task->title, ENT_QUOTES, 'UTF-8') . '</td>';
            $body .= '<td>' . htmlspecialchars($task->project->title ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
            $body .= '<td>' . $difficulty . '</td>';
            $body .= '</tr>';
        }

        $body .= '</tbody></table>';
        $body .= '</body></html>';

        // Send the email
        $result = MailService::sendMail($to, $toName, $subject, $body);

        // Check if the email was sent successfully
        if (!$result) {
            echo "Failed to send email.";
        }
    }
}



function page($identifier)
{
    return Page::where('identifier', $identifier)->first();
}

function upload_image($file)
{
    $path = $file->store('images');
    $file->move('images', $path);
    return $path;
}


function delete_file($file)
{
    if (file_exists($file))
        File::delete($file);
}

function successResponse($data = [], $message = "success", $status = 200)
{
    return response()->json(
        [
            "status" => $status,
            "message" => $message,
            "data" => $data,
        ],
        $status
    );
}

function failedResponse($data = [], $message = "error", $status = 400)
{
    return response()->json(
        [
            "status" => $status,
            "message" => $message,
            "data" => $data,
        ],
        $status
    );
}

function itemsCount($model)
{
    if(auth()->user()->type=='admin'){
        $tasks=count(Task::where('status',0)->get()->unique('title'));
        $finishedTAsks=count(Task::where('status',1)->get()->unique('title'));
        $allTAsks=count(Task::get()->unique('title'));
    }else{
        $tasks=count(Task::where('status',0)->where('employee_id',auth()->user()->id)->get()->unique('title'));
        $finishedTAsks=count(Task::where('status',1)->where('employee_id',auth()->user()->id)->get()->unique('title'));
        $allTAsks=count(Task::where('employee_id',auth()->user()->id)->get()->unique('title'));
    }

    if(auth()->user()->type=='admin'){
        $followups=count(Followup::where('status',0)->get()->unique('title'));
        $finishedTAsks=count(Followup::where('status',1)->get()->unique('title'));
        $allTAsks=count(Followup::get()->unique('title'));
    }else{
        $followups=count(Followup::where('status',0)->where('employee_id',auth()->user()->id)->get()->unique('title'));
        $finishedTAsks=count(Followup::where('status',1)->where('employee_id',auth()->user()->id)->get()->unique('title'));
        $allTAsks=count(Followup::where('employee_id',auth()->user()->id)->get()->unique('title'));}

    $items = [
        "faqs" => count(Faq::get()),
        "messages" => count(Message::get()),
        "counters" => count(Counter::get()),
        "newsletters" => count(Newsletter::get()),
        "contacts" => count(Contact::get()),
        "Portfolios" => count(Gallery::get()),
        "images" => count(Image::get()),
        "pages" => count(Page::get()),
        "accountants" => count(Accountant::get()),
        "historys" => count(History::get()),
        "projects" => count(Project::get()),
        "tasks" => $tasks,
        "finishedTasks" => $finishedTAsks,
        "alltasks" =>$allTAsks,
        "teams" => count(Team::get()),
        "fees" => count(Fee::get()),
        "followups" => $followups,
        "finishedFollowups" => $finishedTAsks,
        "allfollowups" =>$allTAsks,
        "finishedFees" => count(Fee::get()),
        "partners" => count(Partner::get()),
        "services" => count(Service::get()),
        "testimonials" => count(Testimonial::get()),
        "processes" => count(Process::get()),
        "partners" => count(Partner::get()),
        "products" => count(Product::get()),
        "users" => count(User::get()),
        "complains" => count(Complain::get()),
        "vaccancies" => count(Vaccancy::get()),

        "admins" => count(Admin::get()),
        "videos" => count(Video::get()),
        "roles" => count(Role::get()),
        "categories" => count(Category::get()),
    ];


    return $items[$model];
}

function services()
{
    $services = Service::latest()->take(6)->get();

    return $services;
}
function rest($project)
{
    $totalFee=0;
    foreach($project->feeses as $fee){
        if($fee->amount>0)
        $totalFee+=$fee->amount;
    }
    return $project->cost-$totalFee;
}

function getFollowupTitles($followups)
{
    // Extract unique titles
    $titles = $followups->pluck('title')->unique();

    // Format the titles into the desired string with each title on a new line
    return $titles->reduce(function ($carry, $title) {
        return $carry . "start " . $title . "\n";
    }, '');
}


function taskEmployees($title){

    if (request()->routeIs('tasks.index'))
    $employee_ids=Task::where('title',$title)->where('status',0)->pluck('employee_id');
    elseif(request()->routeIs('tasks.all'))
    $employee_ids=Task::where('title',$title)->pluck('employee_id');
    else
    $employee_ids=Task::where('title',$title)->where('status',1)->pluck('employee_id');
    $names=Admin::whereIn('id',$employee_ids)->pluck('name');
    return json_encode($names);
}

function products()
{
    $products = Product::latest()->take(6)->get();

    return $products;
}

function followupEmployees($title){
    $employee_ids=Followup::where('title',$title)->pluck('employee_id');
    $names=Admin::whereIn('id',$employee_ids)->pluck('name');
    return json_encode($names);
}




if (!function_exists('cart')) {

    function cart()
    {

        return Cart::name('shopping')->useForCommercial();
    }
}

if (!function_exists('tasks')) {

    function tasks($type)
    {
        return isset($type) ?  Task::where('type', $type)->get() : Task::latest()->get();;
    }
}

if (!function_exists('task')) {

    function task($type)
    {
      Task::where('type', $type)->first();
    }
}
if (!function_exists('favourite')) {

    function favourite()
    {
        return cart()->newInstance('favourites')->useForCommercial(false);
    }
}

if (!function_exists('followups')) {

    function followups($type)
    {
        return isset($type) ?  Followup::where('type', $type)->get() : Followup::latest()->get();;
    }
}

if (!function_exists('followup')) {

    function followup($type)
    {
      Followup::where('type', $type)->first();
    }
}

if (!function_exists('contacts')) {

    function contacts($type)
    {
        return isset($type) ?  Contact::where('type', $type)->get() : Contact::latest()->get();;
    }
}

if (!function_exists('contact')) {

    function contact($type)
    {
      Contact::where('type', $type)->first();
    }
}

// if (!function_exists('projects')) {

//     function projects($type)
//     {
//         return isset($type) ?  Project::where('type', $type)->get() : Project::latest()->get();;
//     }
// }

if (!function_exists('accountants')) {

    function accountants($type)
    {
        return isset($type) ?  Accountant::where('type', $type)->get() : Accountant::latest()->get();;
    }
}

if (!function_exists('accountant')) {

    function accountant($type)
    {
      Accountant::where('type', $type)->first();
    }
}

if (!function_exists('historys')) {

    function historys($type)
    {
        return isset($type) ?  History::where('type', $type)->get() : History::latest()->get();;
    }
}

if (!function_exists('history')) {

    function history($type)
    {
      History::where('type', $type)->first();
    }
}

function get_size($file_path)
{
    return Storage::size($file_path);
}


function todayDate()
{
    $today = new DateTime();
    $today->setTimezone(new DateTimeZone('Africa/Cairo'));
    $today = $today->format('Y-m-d');
    return $today;
}
function tomorrow()
{
    $tomorrow = new DateTime();
    $tomorrow->setTimezone(new DateTimeZone('Africa/Cairo'));
    $tomorrow = $tomorrow->modify('+1 day')->format('Y-m-d');
    return $tomorrow;
}

function setting()
{
    $setting = Setting::latest()->first();
    return $setting;
}
function settingFirst()
{
    $setting = Setting::first();
    return $setting;
}
function formatStartTime($startTime)
{
    Carbon::parse($startTime)->format('Y-m-d\TH:i:s');
    return $startTime;
}

function getTimeAgo($carbonObject)
{
    $carbonObject = Carbon::parse($carbonObject);
    return str_ireplace(
        [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
        [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
        $carbonObject->diffForHumans()
    );
}

function diffDays($monthYearDate = null, $date2 = null) {
    // If $monthYearDate is null, use the current month and year
    if ($monthYearDate === null) {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth()->endOfDay();
    } else {
        // Parse the month and year from the input date
        list($year, $month) = explode('-', $monthYearDate);
        
        // Get the first and last day of the given month
        $startOfMonth = Carbon::create($year, $month, 1)->startOfDay();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
    }



    // Calculate the difference in days
    $diffInDays = $endOfMonth->diffInDays($startOfMonth);

        // If $date2 is null, use the end of the current month as the end date
        if ($monthYearDate === null || isCurrentMonth($monthYearDate)) {
            $date2 = Carbon::now();
            $diffInDays = $date2->diffInDays($startOfMonth);
        }

    return $diffInDays;
}


function calculateAge($birthdate)
{
    // Convert the birthdate string to a Carbon instance
    $birthdate = Carbon::parse($birthdate);

    // Get the current date
    $currentDate = Carbon::now();

    // Calculate the difference in years, months, and days
    $diff = $currentDate->diff($birthdate);

    // Calculate the age in years and months
    $ageYears = $diff->y;
    $ageMonths = $diff->m;

    // Adjust the age if the current day is before the birth day
    if ($currentDate->day < $birthdate->day) {
        $ageMonths++;
    }

    // Return the age in years and months
    return [
        'years' => $ageYears,
        'months' => $ageMonths
    ];
}



function isCurrentMonth($monthYearDate) {
    // Parse the month and year from the input date
    list($year, $month) = explode('-', $monthYearDate);
    
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Check if the input month and year match the current month and year
    if ($year == $currentYear && $month == $currentMonth) {
        return true;
    } else {
        return false;
    }
}

function flags()
{
    $flags = DB::select("SELECT distinct flag as 'flag' from paths");
    return $flags;
}

function statsColor($index)
{

    $setting = Setting::latest()->get();
    if (isset($setting[$index + 1])) {
        $diff = abs(strtotime($setting[$index]->last_time) - strtotime($setting[$index + 1]->last_time));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        return  $days > 3 ? 'text-success' : 'text-danger';
    }
}

function websites()
{
    return Project::where('appearance',1)->orderBy('title', 'asc')->get();
}
function websitesRoutes()
{
    return Project::where('routesLink','!=',null)->latest()->get();
}
function websitesActive()
{    $string='';
    $websites=Project::where('appearance',1)->where('status','!=',0)->latest()->get();
    foreach($websites as $website){
        $string.=$website->tasks.'</br>********************************</br>';
    }
    return $string;
}

function pathsArr($path) {
    // Check if the path contains an asterisk (*)
    if (strpos($path, '*') === false) {
        dd($path);  // Return 0 if no asterisk is found
    }

    // Replace backslashes with forward slashes and then split by asterisk
    return explode('*', $path);
}

function getLastTwoSegments($path)
{
    // Normalize slashes to forward slashes
    $path = str_replace('\\', '/', $path);

    // Split the path into segments
    $segments = explode('/', $path);

    // Get the last two segments
    $lastTwoSegments = array_slice($segments, -2);

    // Join them with a slash
    return implode('/', $lastTwoSegments);
}
function activeWebsites()
{   
    $websites=Project::where('appearance',1)->where('status','!=',0)->latest()->get();
    return $websites;
}   
function activeWebsitesTitle()
{   
    $websites=Project::where('appearance',1)->where('status','!=',0)->latest()->pluck('title');
    return $websites;
}
function activeWebsitesContent()
{
    $websites = Project::where('appearance', 1)
                    ->where('status', '!=', 0)
                    ->latest()
                    ->pluck('codeLinks'); // Retrieves the collection of 'codeLinks'

    // Merge all non-null values and concatenate into a single string
    $mergedWebsites = $websites->filter()->implode("\n");

    // Debugging: Check the content of $mergedWebsites
    // dd($mergedWebsites); // or log it using Log::info($mergedWebsites);

    // Replace specific words in the merged string
    $mergedWebsites = str_replace('ssh', 'flag', $mergedWebsites);
    $mergedWebsites = str_replace('run dev', 'flag', $mergedWebsites);
    $mergedWebsites = str_replace('start', 'flag', $mergedWebsites);
    $mergedWebsites = str_replace('dashboard', 'flag', $mergedWebsites);
    $mergedWebsites = str_replace('git', 'flag', $mergedWebsites);

    return $mergedWebsites; // Return the modified merged string
}



function References()
{
    return Issue::orderBy('title', 'desc')->get();
}


function accountant()
{
    $payed = DB::select('select sum(cost) as cost, sum(payed) as payed, sum(debit) as debit, sum(fees) as fees from projects');
    return $payed[0];
}
function accountantBoula()
{
    $payed = DB::select('select sum(cost) as cost, sum(payed) as payed, sum(debit) as debit, sum(fees) as fees from boulas');
    return $payed[0];
}

function workMonths(){
    // Assuming $startDate is the specific date from which you want to count months
    // I started 2024-01-01 but I enterd it 2024-02-01 to make it count month after it finsish not when start
    $startDate = Carbon::parse('2024-01-01');
    $endDate = Carbon::now(); // or any other end date you prefer
    // Calculate the difference in months
    $numberOfMonths = $endDate->diffInMonths($startDate);

    // Calculate the fraction of the current month
    $startOfNextMonth = $endDate->copy()->startOfMonth()->addMonth();
    $daysInCurrentMonth = $startOfNextMonth->diffInDays($endDate);
    $daysInMonth = $startOfNextMonth->diffInDays($startOfNextMonth->copy()->endOfMonth());
    $fractionOfMonth = $daysInCurrentMonth / $daysInMonth;

    // Combine whole months and fraction of the current month
    $exactNumberOfMonths = $numberOfMonths;
    return $exactNumberOfMonths+fractionOfDayInMonth();
}

function fractionOfDayInMonth() {
    $currentDate = Carbon::now();
    $daysInMonth = $currentDate->daysInMonth;
    $currentDay = $currentDate->day;

    return $currentDay / $daysInMonth;
}
function DayInMonth() {
    // Set the timezone to Africa/Cairo
    date_default_timezone_set('Africa/Cairo');

    // Get the current date
    $currentDate = Carbon::now();

    // Get the number of days in the current month
    $daysInMonth = $currentDate->daysInMonth;

    // Get the current day of the month
    $currentDay = $currentDate->day;

    return $currentDay;
}


function updated_atPost()
{
    // dd(71);
    $post=Project::latest('updated_at')->first();
    
    return Carbon::parse($post->updated_at)->format('H:i:s');
}
function updated_atBoula()
{
    // dd(71);
    $boula=Boula::latest('updated_at')->first();
    return Carbon::parse($boula->updated_at)->format('H:i:s') ;
}
function updated_atSample()
{
    // dd(71);
    $sample=Sample::latest('updated_at')->first();
    return Carbon::parse($sample->updated_at)->format('H:i:s') ;
}


function countDaysSince($startDate)
{
    $startDate = Carbon::parse($startDate);
    $currentDate = Carbon::now();

    return $currentDate->diffInDays($startDate);
}

function getHourFromDateTime($dateTime)
{
    $date = Carbon::parse($dateTime);
    return $date->hour;
}

function getDateFromDateTime($dateTime) {
    $date = Carbon::parse($dateTime);
    return $date->toDateString();
}
function startAndEndTime($startTime)
{
    $startTimeCarbon = \Carbon\Carbon::parse($startTime);
    $endTimeCarbon = $startTimeCarbon->copy()->addHours(8);
    return [$startTimeCarbon->hour, $endTimeCarbon->hour];
}
function posts()
{
    $posts = Project::get();

    return $posts;
}
function codes()
{
    $codes = Sample::first();

    return $codes;
}

if (!function_exists('taskCommitPer')) {
    /**
     * Check if a given datetime is in the past.
     *
     * @param string $datetime
     * @return bool
     */
    function taskCommitPer()
    {
        $websites = Project::where('appearance', 1)->where('status', '!=', 0)->latest()->pluck('title');
        $done = Server::orderBy('project', 'ASC')->where('committed',1)->whereIn('project', $websites)->get();
        $all = Server::orderBy('project', 'ASC')->whereIn('project', $websites)->get();
        return count($done)/count($all)*100;

}}


function boula()
{
    if(auth()->user()->email=="nessimboula@gmail.com" || App::environment('local'))
    return true;
    return false;
}
