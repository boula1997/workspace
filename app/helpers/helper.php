<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Complain;
use App\Models\Faq;
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
use Illuminate\Support\Facades\File;
use Jackiedo\Cart\Facades\Cart;
use Spatie\Permission\Models\Role;
use App\Services\MailService;

const Message_Mail = "app@gmail.com";

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


function taskLog($action,$task_title){

    $task=Task::where('title',$task_title)->where('employee_id',auth()->user()->id)->first();
    if($task->status==1)
    History::create([
        'action'=>$action,
        'task_id'=>$task->id,
        'employee_id'=>auth()->user()->id,
    ]);
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
    if (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
        abort(403, 'Action not allowed');
    }
}

function received($admin){
    $received=Accountant::where('employee_id',$admin->id)->sum('received');
    if(isset($received) && (auth()->user()->email==$admin->email || 'nessimboula@gmail.com'==auth()->user()->email))
     return $received;
    else
    return 'None';
}
function has($admin){
    $has=Accountant::where('employee_id',$admin->id)->sum('has');
    if(isset($has) && (auth()->user()->email==$admin->email || 'nessimboula@gmail.com'==auth()->user()->email))
     return $has;
    else
    return 'None';
}
function emailTasks()
{
    // Email details
    $to = "nessimboula@gmail.com";
    $toName = "Boula Nessim";
    $subject = 'Tasks Report';

    // Initialize email body
    $easyTasks = Task::where('status', 0)
                     ->where('level', 1)
                     ->orderBy('project_id', 'desc')
                     ->get()
                     ->unique('title');
    $difficultTasks = Task::where('status', 0)
                          ->where('level', 0)
                          ->orderBy('project_id', 'desc')
                          ->get()
                          ->unique('title');

    // Construct the email content
    $body = '<html lang="en"><head><meta charset="UTF-8"><title>Tasks Report</title></head><body>';
    $body .= '<h1>Tasks Report</h1>';

    // Easy Tasks Table
    $body .= '<h2>Easy Tasks</h2>';
    $body .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $body .= '<thead><tr><th>Task</th><th>Project</th></tr></thead><tbody>';
    foreach ($easyTasks as $task) {
        $body .= '<tr>';
        $body .= '<td>' . htmlspecialchars($task->title, ENT_QUOTES, 'UTF-8') . '</td>';
        $body .= '<td>' . htmlspecialchars($task->project->title ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
        $body .= '</tr>';
    }
    $body .= '</tbody></table>';

    // Difficult Tasks Table
    $body .= '<h2>Difficult Tasks</h2>';
    $body .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $body .= '<thead><tr><th>Task</th><th>Project</th></tr></thead><tbody>';
    foreach ($difficultTasks as $task) {
        $body .= '<tr>';
        $body .= '<td>' . htmlspecialchars($task->title, ENT_QUOTES, 'UTF-8') . '</td>';
        $body .= '<td>' . htmlspecialchars($task->project->title ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
        $body .= '</tr>';
    }
    $body .= '</tbody></table>';

    $body .= '</body></html>';

    // Send the email
    $result = MailService::sendMail($to, $toName, $subject, $body);

    // Check if the email was sent successfully
    if ($result) {
     
    } else {
        echo "Failed to send email.";
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
    foreach($project->fees as $fee){
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

// if (!function_exists('project')) {

//     function project($type)
//     {
//       Project::where('type', $type)->first();
//     }
// }
