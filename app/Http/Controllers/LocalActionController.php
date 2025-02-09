<?php

namespace App\Http\Controllers;

use App\Models\Boula;
use App\Models\Template;
use App\Models\Googlead;
use App\Models\Image;
use App\Models\Issue;
use App\Models\Path;
use App\Models\Post;
use App\Models\Project;
use App\Models\Query;
use App\Models\Sample;
use App\Models\DBCredential;
use App\Models\Script;
use App\Models\Server;
use App\Models\Setting;
use App\Models\Time;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class LocalActionController extends Controller
{

  protected $employees = ['none','back','front','both'];
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $action = "";
    return view('welcome', compact('action'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  public function templates()
  {
      // Fetch all templates
      $templates = Template::all();

      // Return them as JSON response
      return response()->json([
          'data' => $templates
      ]);
  }
  public function googleads()
  {
      // Fetch all templates
      $googleads = Googlead::all();

      // Return them as JSON response
      return response()->json([
          'data' => $googleads
      ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $selectFlag=$request->selectFlag;
    $flag='';
    if (isset($request->newPaths)) {
      $newPaths = str_replace('/', '\\', $request->newPaths);
      $paths = explode(" ", $newPaths);
      if (request()->has('overwrite'))
        DB::table('paths')->truncate();
      foreach ($paths as $path) {
        if (str_contains($path, '.html')) {
          Path::create(["path" => 'http://localhost/' . $request->templateName . '/' . $path, 'flag' => $request->flag]);
        }
        if ($request->has('linkPHP')) {
          if (str_contains($path, '.php')) {
            Path::create(["path" => 'http://localhost/' . $request->templateName . '/' . $path, 'flag' => $request->flag]);
          }
        }
        if (str_contains($path, '"')) {
          $elements = explode('"', $path);
          $path = $elements[1];
          foreach (explode('\\', $path) as $slashelement) {
            if (str_contains($slashelement, ':')) {
              if ($slashelement == ':lang')
                $path = str_replace('\:lang', '\ar', $path);
              else if ($slashelement == ':locale')
                $path = str_replace('\:locale', '\ar', $path);
              else
                $path = str_replace($slashelement, '1', $path);
            }
          }
          Path::create(["path" => 'http://localhost:5173' . $path, 'flag' => $request->flag]);
        }
        Path::create(["path" => $path, 'flag' => $request->flag]);
      }

      return redirect()->back()->with(['success' => "Created Succesfully"]);
    }
    $action = $request->action;
    $replaced = $request->has('newPaths') ? $request->newPaths : null;
    $module = $request->has('name') ? $request->name : null;
    $rmodule = $request->has('rname') ? $request->rname : null;


    if ($request->action == '0' || $request->action == '2') {
      $action = $request->action == '0' ? 'create new module(or Open newly added module)' : 'Rename module';
        
      // auto attributes
      $attributes = explode(',', $request->attribute);
      $types = explode(',', $request->type);
      $replaceWords = ['undefined', 'Undefined'];
      $replacementWords = ['attribute', 'Attribute'];
      $module = $request->module;
      $resultsauto = [];
      $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration",'json'];
      
        foreach ($attributes as $key => $value) {
          if (isset($types[$key])) {
              $type = $types[$key];
              
              foreach ($titles as $title) {
                  $script = Sample::where('stack',$request->stack)->where('type', $type)->where('title', $title)->first();
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('type', 'all')->where('title', $title)->first();
                  }
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('title', $title)->first();
                  }
                  
                  
                  // Replace placeholders in the script with the corresponding name and module
                  $tempScript = str_replace($replaceWords, [$value, ucfirst($value)], isset($script)?$script->script:'');
                  $finalScript = str_replace('module', $module, $tempScript);
  
                  $resultsauto[] = [
                      'script_name' => isset($script)?$script->title:'', // Assuming each script has a title attribute
                      'results' => [$finalScript]
                  ];
              }
          }
      }
      // Sort results by 'script_name'
      usort($resultsauto, function ($a, $b) {
          return strcmp($a['script_name'], $b['script_name']);
      });
      // auto attributes
      $module = $request->has('name') ? $request->name : null;
      $plural = $request->plural;
      $data = $request->all();
      $rmodule = $request->has('rname') ? $request->rname : null;

      if (isset($plural)) {
        $results = DB::select("Select concat(path ,'*',replace(replace(replace(replace(path,'" . $request->name . 's' . "','" . $request->plural . "'),'" . ucfirst($request->name) . 's' . "','" . ucfirst($request->plural) . "'),'" . $request->name . "','" . $request->rname . "'),'" . ucfirst($request->name) . "','" . ucfirst($request->rname) . "')) as path from paths where flag='" . $request->selectFlag . "' and path like '%" . $request->name . "%" . $request->extension ."' or path like '%" . $request->name . "%" . $request->extension ."x". "';");
        $resultsTranslation = DB::select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
        $dbname = $request->dbname;
        return view('welcome', compact('results', 'action', 'data', 'replaced', 'module', 'plural', 'rmodule','selectFlag','resultsTranslation','dbname'));
      } else {
        $results = DB::select("Select concat(path ,'*',replace(replace(path,'" . $request->name . "','" . $request->rname . "'),'" . ucfirst($request->name) . "','" . ucfirst($request->rname) . "')) as path from paths where flag='" . $request->selectFlag . "' and path like '%" . $request->name . "%" . $request->extension ."' or path like '%" . $request->name . "%" . $request->extension ."x". "';");

        $resultsTranslation = DB::select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
        $dbname = $request->dbname;
        return view('welcome', compact('results', 'action', 'data', 'replaced', 'module', 'rmodule','resultsauto','selectFlag','resultsTranslation','dbname'));
      }
    }

    if ($request->action == '1' || $request->action == '3' || $request->action == '6' || $request->action == '20') {
      $action = $request->action == '1' ? 'Delete multible module' : ($request->action == '3' ? 'Open multible modules' : ($request->action == '20' ? 'Reblace word in module' : 'copy multible modules using repo'));


      // auto attributes
      $attributes = explode(',', $request->attribute);
      $types = explode(',', $request->type);
      $replaceWords = ['undefined', 'Undefined'];
      $replacementWords = ['attribute', 'Attribute'];
      $module = $request->module;
      $resultsauto = [];
      $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration",'json'];
      
        foreach ($attributes as $key => $value) {
          if (isset($types[$key])) {
              $type = $types[$key];
              
              foreach ($titles as $title) {
                  $script = Sample::where('stack',$request->stack)->where('type', $type)->where('title', $title)->first();
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('type', 'all')->where('title', $title)->first();
                  }
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('title', $title)->first();
                  }
                  
                  
                  // Replace placeholders in the script with the corresponding name and module
                  $tempScript = str_replace($replaceWords, [$value, ucfirst($value)], isset($script)?$script->script:'');
                  $finalScript = str_replace('module', $module, $tempScript);
  
                  $resultsauto[] = [
                      'script_name' => isset($script)?$script->title:'', // Assuming each script has a title attribute
                      'results' => [$finalScript]
                  ];
              }
          }
      }
      // Sort results by 'script_name'
      usort($resultsauto, function ($a, $b) {
          return strcmp($a['script_name'], $b['script_name']);
      });
      // auto attributes

      // Search multible in sql
      $array = explode(',', $request->name);
      array_push($array, 'http:');
      array_push($array, 'https:');

      foreach ($array as $item) {
        $extension = $item == 'http:' || $item == 'https:' ? '' : $request->extension;
        $sql[] = "path LIKE '%" . $item . "%" . $extension . "'";
        if ($extension = 'js') {
          $sql[] = "path LIKE '%" . $item . "%" . $extension . "x'";
        }
      }


      $results = DB::select("select * from paths where flag='" . $request->selectFlag . "' and  (" . implode(" OR ", $sql) . ");");
      $repo = $request->repolink;
      $prepo = $request->projectrepolink;

      $word = $request->word;
      $replaceWord = $request->replaceWord;
      if($request->action!=6)
      $resultsTranslation = DB::select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
       else
       $resultsTranslation=[];
      $dbname = $request->dbname;

      return view('welcome', compact('results', 'action', 'replaced', 'module', 'rmodule', 'repo', 'prepo', 'array', 'word', 'replaceWord','resultsauto','selectFlag','resultsTranslation','dbname'));
    }


    if ($request->action == '4') {
      $action = "Get files with size bigger than";
      $results = DB::select("select * from paths where flag='" . $request->selectFlag . "' and path like '%.jpg%'");
      $size = $request->size;
      return view('welcome', compact('results', 'action', 'size', 'replaced', 'module','flag'));
    }
    if ($request->action == '5') {
      $action = "Show or Delete project images";
      // select database and add query
      $usedFiles = DB::select("select db, id, url from (select '" . $request->dbname . "' as db, files.* from " . $request->dbname . ".files) as q;");
      $dbname = $request->dbname;


      return view('welcome', compact('usedFiles', 'action', 'replaced', 'module', 'dbname','flag'));
    }
    if ($request->action == '7') {
      $action = "translate all attributes";
      //show database attributes
      $results = DB::select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");

      $dbname = $request->dbname;



    

      return view('welcome', compact('results', 'action', 'replaced', 'module', 'dbname','flag'));
    }

    if ($request->action == '8' || $request->action == '10') {
      $action = $request->action == '8' ? "Search all attributes at once" : "search project modules";
      $results = DB::select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");
      $modules = DB::select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "' order by TABLE_NAME;");
      $dbname = $request->dbname;
      $string = '';
      $string2 = '';


      foreach ($results as $key => $value) {
        if ($key !== count($results) - 1)
          $string .= '("' . $value->COLUMN_NAME . '")|' . "('" . $value->COLUMN_NAME . "')|";
        else
          $string .= $string .= '("' . $value->COLUMN_NAME . '")|' . "('" . $value->COLUMN_NAME . "')";
      }
      foreach ($results as $key => $value) {
        if ($key !== count($results) - 1)
          $string2 .= '(->' . $value->COLUMN_NAME . ')|';
        else
          $string2 .= '(->' . $value->COLUMN_NAME . ')';
      }



      $string = str_replace(' ', '', $string);
      $string2 = str_replace(' ', '', $string2);;
      $string3 = '';
      $modules = DB::select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "' order by TABLE_NAME;");
      foreach ($modules as $key => $value) {
        if (!str_contains($value->TABLE_NAME, 'translations')) {

          if ($key !== count($modules) - 1)
            $string3 .= '(' . rtrim(str_replace('ies', '', $value->TABLE_NAME), "s") . ')|';
          else
            $string3 .= $string3 .= '(' . rtrim(str_replace('ies', '', $value->TABLE_NAME), "s") . ')';
        }
      }

      return view('welcome', compact('results', 'action', 'replaced', 'module', 'string', 'string2', 'modules', 'dbname', 'string3','flag'));
    }


    if ($request->action == '9') {
      $action = 'Prebare multible modules to work on';

      // Search multible in sql
      $array = explode(',', $request->name);
      array_push($array, 'http:');
      array_push($array, 'https:');

      foreach ($array as $item) {
        $extension = $item == 'http:' || $item == 'https:' ? '' : $request->extension;
        $sql[] = "path LIKE '%" . $item . "%" . $extension . "'";
        if ($extension = 'js') {
          $sql[] = "path LIKE '%" . $item . "%" . $extension . "x'";
        }
      }




      $results = DB::select("select * from paths where flag='" . $request->selectFlag . "' and (" . implode(" OR ", $sql) . ");");
      $results2 = DB::select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");

      $dbname = $request->dbname;

      $string = '';
      $string2 = '';
      $string3 = '';
      foreach ($results2 as $key => $value) {
        if ($key !== count($results2) - 1)
          $string .= '("' . $value->COLUMN_NAME . '")|' . "('" . $value->COLUMN_NAME . "')|";
        else
          $string .= $string .= '("' . $value->COLUMN_NAME . '")|' . "('" . $value->COLUMN_NAME . "')";
      }
      foreach ($results2 as $key => $value) {
        if ($key !== count($results2) - 1)
          $string2 .= '(->' . $value->COLUMN_NAME . ')|';
        else
          $string2 .= '(->' . $value->COLUMN_NAME . ')';
      }
      foreach ($results2 as $key => $value) {
        if ($key !== count($results2) - 1)
          $string3 .= '(' . $value->COLUMN_NAME . ')|';
        else
          $string3 .= '(' . $value->COLUMN_NAME . ')';
      }

      $string = str_replace(' ', '', $string);
      $string2 = str_replace(' ', '', $string2);
      $string3 = str_replace(' ', '', $string3);

      return view('welcome', compact('array', 'results', 'results2', 'action', 'replaced', 'module', 'string', 'string2', 'string3', 'dbname','flag'));
    }


    if ($request->action == '11') {
      $action = "Open Shared Module Files";
      $string3 = '';
      $modules = DB::select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "' order by TABLE_NAME;");
      foreach ($modules as $key => $value) {
        if (!str_contains($value->TABLE_NAME, 'translations')) {

          if ($key !== count($modules) - 1)
            $string3 .= '(' . rtrim(str_replace('ies', '', $value->TABLE_NAME), "s") . ')|';
          else
            $string3 .= $string3 .= '(' . rtrim(str_replace('ies', '', $value->TABLE_NAME), "s") . ')';
        }
      }
      return view('welcome', compact('action', 'string3','flag'));
    }


    if ($request->action == '12') {
      $action = 'desc database';
      

      $queries=Query::latest()->get()->unique('title');
      $results = DB::select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");
      $tables = DB::select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "' order by TABLE_NAME;");
      $array = [];
      $array2 = [];
      $letters = [];
      $dataTypes=[];
      $counts=[];
      foreach ($tables as $table) {
        $string = '';
        $string2 = '';
        $datatype = '';
        DB::select('use '.$request->dbname.';');
        $count=DB::select('SELECT COUNT(*) AS count FROM '.$table->TABLE_NAME.';');
        // Access the count as an integer
        $rowCount = $count[0]->count;
        foreach ($results as $result) {
          if ($result->TABLE_NAME == $table->TABLE_NAME) {

            $string .= $result->COLUMN_NAME . ' ';
            $datatype .= $result->DATA_TYPE . ' ';
            if (str_contains($result->COLUMN_NAME, '_id'))
              $string2 .= $result->COLUMN_NAME . ' ';
          }
        }
        array_push($array, $string);
        array_push($array2, $string2);
        array_push($dataTypes, $datatype);
        array_push($letters, $table->TABLE_NAME[0]);
        array_push($counts, $rowCount);
      }


      DB::select('use '.env('DB_DATABASE').';');

      $dbname = $request->dbname;






      $credential=DBCredential::where('db_name',isset($dbname)?$dbname:'yousabte_automation')->first();

      return view('welcome', compact('results', 'tables', 'action', 'replaced', 'module', 'array', 'dbname', 'letters', 'array2','dataTypes','queries','credential','counts'));
    }

    if ($request->action == '13') {
      $action = "translate untranslated words";
      $results = DB::select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
      $dbname = $request->dbname;
      return view('welcome', compact('results', 'action', 'dbname'));
    }
    if ($request->action == '24') {
      $action = "Add new template link";
      $dbname = $request->dbname;
      Template::create(['link'=>$request->dbname]);
      return redirect()->back();
    }
    if ($request->action == '27') {
      $action = "Add new googlead link";
      $dbname = $request->dbname;
      Googlead::create(['link'=>$request->dbname]);
      return redirect()->back();
    }

    if ($request->action == '14') {
      $action = "checkout multible module";
      $array = explode(',', $request->name);


      foreach ($array as $item) {
        $extension = $item == 'http:' || $item == 'https:' ? '' : $request->extension;
        $sql[] = "path LIKE '%" . $item . "%" . $extension . "'";
        if ($extension = 'js') {
          $sql[] = "path LIKE '%" . $item . "%" . $extension . "x'";
        }
      }


      $results = DB::select("select * from paths where flag='" . $request->selectFlag . "' and (" . implode(" OR ", $sql) . ");");
      $commit = $request->commit;
      return view('welcome', compact('results', 'action', 'commit','flag'));
    }

    if ($request->action == '15') {
      if ($request->has('projectContent')) {
        $action = "add script";
        $contents = explode(".php:", $request->script);
        if (request()->has('overwrite'))
          DB::table('projects')->truncate();
        foreach ($contents as $content) {
          Project::create(['script' => $content]);
        }
        return redirect()->back()->with(['success' => "Created Succesfully"]);
      } else {
        Script::create(["script" => $request->script]);
        return redirect()->back()->with(['success' => "Created Succesfully"]);
      }
    }

    if ($request->action == '16') {

      
      if ($request->has('projectContent')) {
        $action = "get multible modules";
        $array = explode(',', $request->script);
        
        foreach ($array as $item) {
          $sql[] = "script LIKE '%" . $item . "%'";
        }
        $results = DB::select("select * from projects where " . implode(" AND ", $sql) . "order by id asc;");
        return view('welcome', compact('results', 'action', 'array','flag'));
      } else {
        $action = "get multible scripts";
        $array = explode(',', $request->script);
        $searchRefrences=false;
        if(isset(request()->searchRefrences)){
          
          $searchRefrences=true;
          foreach ($array as $item) {
            $sql[] = "script  LIKE '%" . $item . "%'";
          }
          $results = DB::select("select * from issues where " . implode(" AND ", $sql) . "order by id desc;");
        }
        else{
          foreach ($array as $item) {
            $sql[] = "script LIKE '%" . $item . "%'";
          }

          $results = DB::select("select * from scripts where " . implode(" AND ", $sql) . "order by id desc;");
        }
        return view('welcome', compact('results', 'action', 'array','searchRefrences'));
      }
    }

    if ($request->action == '17') {
      $action = "Servers Hostings and git default";
      return view('welcome', compact('action','flag'));
    }
    if ($request->action == '18') {
      $action = "Image Workspace";
      $images = Image::get();
      return view('welcome', compact('action', 'images','flag'));
    }


    if ($request->action == '19') {
      $action = "flags manager";
      $flags = DB::select("SELECT distinct flag as 'flag' from paths");

      return view('welcome', compact('action', 'flags','flag'));
    }

    if ($request->action == '21') {
      $action = "Get Stats";
      $currentMonth = Carbon::now()->month;
      $data = Setting::whereRaw('MONTH(last_time) = ?', [$currentMonth])->latest()->get();
      $last = Setting::latest()->first();
      $timeClicks = Time::whereRaw('MONTH(clickTime) = ?', [$currentMonth])->latest()->get();
      // Group clicks by day
      $clicksByDay = $timeClicks->groupBy(function ($click) {
        // Parse the clickTime string to DateTime object before formatting
        $clickTime = \Carbon\Carbon::parse($click->clickTime);
        return $clickTime->format('Y-m-d'); // Group by date
      });


      return view('welcome', compact('action', 'data', 'last','timeClicks','clicksByDay','flag'));
    }
    if ($request->action == '23') {
      $action = "auto attributes";
      $attributes = explode(',', $request->attribute);
      $types = explode(',', $request->type);
      $replaceWords = ['undefined', 'Undefined'];
      $replacementWords = ['attribute', 'Attribute'];
      $module = $request->module;
      $results = [];
      $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration",'json'];

        foreach ($attributes as $key => $value) {
          if (isset($types[$key])) {
              $type = $types[$key];
              
              foreach ($titles as $title) {
                  $script = Sample::where('stack',$request->stack)->where('type', $type)->where('title', $title)->first();
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('type', 'all')->where('title', $title)->first();
                  }
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('title', $title)->first();
                  }
  
                  // Replace placeholders in the script with the corresponding name and module
                  $tempScript = str_replace($replaceWords, [$value, ucfirst($value)], isset($script)?$script->script:'');
                  $finalScript = str_replace('module', $module, $tempScript);
  
                  $results[] = [
                      'script_name' => isset($script)?$script->title:'', // Assuming each script has a title attribute
                      'results' => [$finalScript]
                  ];
              }
          }
      }
      // Sort results by 'script_name'
      usort($results, function ($a, $b) {
          return strcmp($a['script_name'], $b['script_name']);
      });
  
      return view('welcome', compact('action', 'results','flag'));
  }
  
  if ($request->action == '25') {
    $action = "React post";
    $baseUrl = $request->dbname;
    $component = $request->templateName;
    $function = $request->repolink;
    $attribute = $request->projectrepolink;
    $clientUrl = $request->commit;
    $endpoint = $request->word;

    // Fetch the issue data
    $issue = Issue::where('title', 'React post')->first();
    $content = $issue->codeLinks;

    // Replace the specific URL with $baseUrl
    $content = str_replace('https://yousab-tech.com/academy/public/api/', $baseUrl, $content);
    $content = str_replace('ContactUs', $component, $content);
    $content = str_replace('message', '/'.$endpoint, $content);
    $content = str_replace('demo', $attribute, $content);
    
    $attributes = explode(',', $request->attribute);
    $types = explode(',', $request->type);
    $replaceWords = ['undefined', 'Undefined'];
    $replacementWords = ['attribute', 'Attribute'];
    $module = $request->module;
    $results = [];
    $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration",'json'];

        foreach ($attributes as $key => $value) {
          if (isset($types[$key])) {
              $type = $types[$key];
              
              foreach ($titles as $title) {
                  $script = Sample::where('stack',$request->stack)->where('type', $type)->where('title', $title)->first();
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('type', 'all')->where('title', $title)->first();
                  }
                  if (!isset($script)) {
                      $script = Sample::where('stack',$request->stack)->where('title', $title)->first();
                  }
  
                  // Replace placeholders in the script with the corresponding name and module
                  $tempScript = str_replace($replaceWords, [$value, ucfirst($value)], isset($script)?$script->script:'');
                  $finalScript = str_replace('module', $module, $tempScript);
  
                  $results[] = [
                      'script_name' => isset($script)?$script->title:'', // Assuming each script has a title attribute
                      'results' => [$finalScript]
                  ];
              }
          }
      }
      // Sort results by 'script_name'
      usort($results, function ($a, $b) {
          return strcmp($a['script_name'], $b['script_name']);
      });

    return view('welcome', compact('action','results', 'content', 'flag'));
}

if ($request->action == '29') {
  $action = "Ajax post";
  $formid = $request->dbname;
  $routename = $request->module;

  // Fetch the issue data
  $issue = Issue::where('title', 'Ajax post')->first();
  $content = $issue->codeLinks;

  // Replace the specific URL with $baseUrl
  $content = str_replace('message.store', $routename, $content);
  $content = str_replace('contactForm', $formid, $content);
  $results=[];
  return view('welcome', compact('action','results', 'content', 'flag'));
}
if ($request->action == '28') {
  $action = "Ajax get";
  $url = $request->dbname;
  $attribute = $request->module;

  // Fetch the issue data
  $issue = Issue::where('title', 'Ajax get')->first();
  $content = $issue->codeLinks;

  // Replace the specific URL with $baseUrl
  $content = str_replace('products', $url, $content);
  $content = str_replace('productId', $attribute, $content);
  $results=[];
  return view('welcome', compact('action','results', 'content', 'flag'));
}
  if ($request->action == '26') {
    $action = "React get";
    $baseUrl = $request->dbname;
    $component = $request->templateName;
    $function = $request->repolink;
    $clientUrl = $request->commit;
    $endpoint = $request->word;

    // Fetch the issue data
    $issue = Issue::where('title', 'React get')->first();
    $content = $issue->codeLinks;

    // Replace the specific URL with $baseUrl
    $content = str_replace('https://yousab-tech.com/academy/public/api', $baseUrl, $content);
    $content = str_replace('Courses', $component, $content);
    $content = str_replace('courses', $endpoint, $content);
    $results=[];
    return view('welcome', compact('action','results','content', 'flag'));
}
  
  
  

  }

  /**
   * Display the specified resource.
   */
  public function show($db, $table, $query)
  {
    
    $result = DB::statement('use ' . $db . '');

    if ($query !== "null" && $query !== "")
      $queyData = DB::select($query);
    else
      $queyData = null;
    //  determin database and column name
    $data = DB::select("  
    SELECT * 
    FROM (
        SELECT '" . $db . "' AS db, " . $table . ".* 
        FROM " . $db . "." . $table . "
        ORDER BY updated_at DESC
        LIMIT 1000
    ) AS q;
");



$totalCount = DB::select("  
SELECT count(*) as count 
FROM (
    SELECT '" . $db . "' AS db, " . $table . ".* 
    FROM " . $db . "." . $table . "
    ORDER BY updated_at DESC
) AS q;
");


$count=$totalCount[0]->count;


    return response()->json(['success' => trans('general.sent_successfully'), 'data' => $data, 'queryData' => $queyData,'count' => $count]);
  }

  public function filterStats(Request $request)
  {
    $action = "Get Stats";
    $monthYear = $request->input('start');
    // Get the input date
    $inputDate = Carbon::createFromFormat('Y-m', $request->input('start'))->startOfMonth();

    // Get the year and month from the input date
    $year = $inputDate->year;
    $month = $inputDate->month;
    $currentMonth = Carbon::now()->month;
    // Filter the settings table
    $data = Setting::whereYear('last_time', $year)
      ->whereMonth('last_time', $month)->latest()
      ->get();
    $timeClicks= Time::whereYear('clickTime', $year)
      ->whereMonth('clickTime', $month)->latest()
      ->get();

      // Group clicks by day
      // Group clicks by day
      $clicksByDay = $timeClicks->groupBy(function ($click) {
        // Parse the clickTime string to DateTime object before formatting
        $clickTime = \Carbon\Carbon::parse($click->clickTime);
        return $clickTime->format('Y-m-d'); // Group by date
      });
      

      
    $last = Setting::latest()->first();
    return view('welcome', compact('action', 'data', 'last', 'monthYear','timeClicks','clicksByDay'));
  }
  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Path $path)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Path $path)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    if (request()->routeIs('actions.destroy'))
      DB::statement('delete from paths where flag="' . $id . '"');
    else if(request()->routeIs('delete.scripts')) {
      $script = Script::find($id);
      $script->delete();
    }else{
      $project = Project::find($id);
      $project->delete();

    }
    return response()->json(['success' => "Deleted Successfully"]);
  }

  public function execQuery(Request $request)
  {
    try {
      $result = DB::statement('use automation');
      $query=Query::where('title',$request->queryCommand)->first();
      if(!isset($query))
      $query=Query::create([
        'title'=>$request->queryCommand
      ]);
      $queries=Query::latest()->take(100)->get()->unique('title');
      $queryTitles=$queries->pluck('title')->toArray();
      $result = DB::statement('use ' . $request->dbname . '');
      $data = DB::select($request->queryCommand);
      return response()->json(['success' => "Done Successfully", 'data' => $data,'query'=>$request->queryCommand]);
    } catch (\Exception $e) {
      return response()->json(['success' => $e->getMessage(), 'data' => [],'query'=>$request->queryCommand]);
    }
  }

  public function lastUpdate($date)
  {

    $setting = Setting::latest()->first();
    if ($setting->last_time != $date)
      $setting = Setting::create(['last_time' => $date]);
    return response()->json(['success' => trans('general.sent_successfully'), 'date' => $setting->last_time]);
  }


  public function uploadImages(Request  $request)
  {

    $action = "Image Workspace";
    $allimages = Image::get();

    if (request()->has('overwrite')) {
      foreach ($allimages as $image) {
        if (file_exists($image->url))
          File::delete($image->url);
      }
      DB::table('images')->truncate();
    }
    foreach ($request->file('files') as $file) {
      $image = $file->getClientOriginalName();
      $file->move('images', $image);
      Image::create(['url' => 'images/' . $image]);
    }

    $images = Image::get();
    return view('welcome', compact('images', 'action'));
  }

  public function websiteToggle($id)
  {
    $website = Project::find($id);
    if (request()->routeIs('website.dbltoggle')) {
      if ($website->status == 0)
        $website->update(['status' => 2]);
      else
        $website->update(['status' => 0]);
    }
    if (request()->routeIs('website.trpltoggle')) {
      if ($website->status == 0)
        $website->update(['status' => 3]);
      else
        $website->update(['status' => 0]);
    }
    if (request()->routeIs('website.toggle')) {
      if ($website->status == 0)
        $website->update(['status' => 1]);
      else
        $website->update(['status' => 0]);
    }

    return response()->json(['success' => trans('general.sent_successfully'), 'status' => $website->status]);
  }

  public function updatePosts(Request $request){
    $post=Project::find($request->post_id);
    $post->update(['codeLinks'=>$request->codeLinks]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }

  public function updateSamples(Request $request){
    $sample=sample::find($request->sample_id);
    $sample->update(['script'=>$request->script]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }

  public function updateReferences(Request $request){
    $issue=Issue::find($request->issue_id);
    $issue->update(['codeLinks'=>$request->codeLinks]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }
  public function updateTasks(Request $request){
    $tasks=explode('********************************',$request->tasks);
    foreach(activeWebsites() as $key=>$value)
    $value->update(['tasks'=>$tasks[$key]]);
    return response()->json(['success' => trans('general.created_successfully')]);

  }


  public function updateBoulas(Request $request){
    $boula=Boula::find($request->boula_id);
    $boula->update(['tasks'=>$request->tasks]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }
  public function issueUpdate(Request $request){
    $issue=Issue::find($request->issue_id);
    $issue->update(['codeLinks'=>$request->codeLinks]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }
  public function serverUpdate(Request $request){
    $server=Server::find($request->server_id);
    $server->update(['script'=>$request->script]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }


  public function websitesImportant()
  {

           // Get a random website where status is 1 or 2
           $post = Project::whereIn('status', [1,2,3])->where('appearance',1)->inRandomOrder()->first();
           // Handle the case where no website is found
           if ($post === null) {
               return response()->json(['success' => 'No websites found with status 1 or 2']);
           }
   
           return response()->json(['success' => $post->title, 'status' => $post->status,'post_id'=>$post->id]);
       }

  public function tasksImportant()
  {

           // Get a random website where status is 1 or 2
           $server = Server::where('committed', 0)->where('personal', 0)->inRandomOrder()->first();
           // Handle the case where no website is found
           if ($server === null) {
               return response()->json(['success' => 'No tasks found']);
           }
   
           return response()->json(['success' => $server->title, 'status' => 2,'server_id'=>$server->id]);
       }


       public function createClickTime(Request $request){
        // Get the last record from the times table
        $lastRecord = Time::latest()->first();
        if (!$lastRecord || $lastRecord->clickTime->format('Y-m-d H:i') !== now()->format('Y-m-d H:i')) {
            // Create a new record
            Time::create($request->all());
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Click already recorded in the same minute']);
    }

    public function createStartTime(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'startTime' => 'required|date',
        ]);

        // Store the datetime in the database
        $setting =Setting::first();
        $currentDate = Carbon::now()->format('Y-m-d');
        $startDate = Carbon::parse($setting->startTime)->format('Y-m-d');
        if($startDate!== $currentDate || request()->routeIs('reset.datetime')){
          $setting->update(['startTime'=>$validated['startTime']]);
          // Return a response
          return response()->json(['success' => true]);
          }
        return response()->json(['success' => false]);
    }
    public function updateStartTime(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'startTime' => 'required|date',
        ]);

        // Store the datetime in the database
        $setting =Setting::first();
        $currentDate = Carbon::now()->format('Y-m-d');
        $startDate = Carbon::parse($setting->startTime)->format('Y-m-d');
        $setting->update(['startTime'=>$validated['startTime']]);
        return response()->json(['success' => true]);

    }
     

    public function toggleDealPost($id)
    {
      $post=Project::find($id);
      if($post->deal){
        $post->update(['deal'=>0]);
        $post->update(['appearance'=>0]);

      }
      else
      $post->update(['deal'=>1]);
      return response()->json(['success' => 'Changed Successfully','status'=>$post->deal]);

    }
    public function toggleShowPost($id)
    {
      $post=Project::find($id);
      if($post->appearance)
      $post->update(['appearance'=>0]);
      else
      $post->update(['appearance'=>1]);

      return response()->json(['success' => 'Changed Successfully','status'=>$post->appearance]);

    }
    
    public function toggleDealBoula($id)
    {
      $boula=Boula::find($id);
      if($boula->deal)
      $boula->update(['deal'=>0]);
    else
    $boula->update(['deal'=>1]);
    return response()->json(['success' => 'Changed Successfully','status'=>$boula->deal]);

    }
    public function toggleCommited($id)
    {
      $server=Server::find($id);
      if($server->committed)
      $server->update(['committed'=>0]);
      else
      $server->update(['committed'=>1]);
      return response()->json(['success' => 'Changed Successfully','status'=>$server->committed]);

    }
    public function toggleask($id)
    {
      $server=Server::find($id);
      if($server->ask)
      $server->update(['ask'=>0]);
      else
      $server->update(['ask'=>1]);
      return response()->json(['success' => 'Changed Successfully','status'=>$server->ask]);

    }
    public function toggleeasy($id)
    {
      $server=Server::find($id);
      if($server->easy)
      $server->update(['easy'=>0]);
      else
      $server->update(['easy'=>1]);
      return response()->json(['success' => 'Changed Successfully','status'=>$server->easy]);

    }
    public function toggleactive($id)
    {
      $server=Server::find($id);
      if($server->active)
      $server->update(['active'=>0]);
      else
      $server->update(['active'=>1]);
      return response()->json(['success' => 'Changed Successfully','status'=>$server->active]);

    }

    public function cycleEmployee(Request $request)
    {
        $server = Server::find($request->server_id);

        if ($server) {
            $currentEmployee = $server->employee;
            $currentIndex = array_search($currentEmployee, $this->employees);
            $nextIndex = ($currentIndex + 1) % count($this->employees);
            $server->employee = $this->employees[$nextIndex];
            $server->save();

            return response()->json(['success' => true, 'new_employee' => $server->employee]);
        }

        return response()->json(['success' => false]);
    }
}
