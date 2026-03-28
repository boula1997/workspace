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
use App\Models\Navigation;
use App\Models\Script;
use App\Models\Server;
use App\Models\Setting;
use App\Models\Time;
use App\Models\Website;
use App\Models\DBCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ActionController extends Controller
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
  public function excavations()
  {
      // Fetch all templates
       $excavations = Navigation::where("isExcavation",1)->get();

      // Return them as JSON response
      return response()->json([
          'data' => $excavations
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


      $credential=DBCredential::where('db_name',isset($request->dbname)?$request->dbname:'yousabte_automation')->first();
      $dbHost = isset($credential->db_host)?$credential->db_host:'192.185.41.219';
      $dbName = isset($credential->db_name)?$credential->db_name:'yousabte_automation';
      $dbUser = isset($credential->db_username)?$credential->db_username:'yousabte_automation';
      $dbPass = isset($credential->db_password)?$credential->db_password:'o$01Yqf{R;s6';
          // Temporarily configure the database connection
          config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);
  
            // Use the dynamic connection
      DB::purge('dynamic');
      DB::reconnect('dynamic');


    $selectFlag=$request->selectFlag;
    $flag='';
    if (isset($request->newPaths)) {
      $newPaths = str_replace('/', '\\', $request->newPaths);
      $paths = explode(" ", $newPaths);
      if (request()->has('overwrite'))
        DB::connection('dynamic')->table('paths')->truncate();
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
      $action = $request->action == '0' ? 'create new module' : 'Rename module';
        
      // auto attributes (edit first methodology to avoid filling data)
      $attributes = explode(',', $request->attribute);
      $types = explode(',', $request->type);
      $replaceWords = ['undefined', 'Undefined'];
      $replacementWords = ['attribute', 'Attribute'];
      $module = $request->module;
      $resultsauto = [];
      $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration","dropMigration",'json'];
      
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
      // auto attributes (edit first methodology to avoid filling data)
      $module = $request->has('name') ? $request->name : null;
      $plural = $request->plural;
      $data = $request->all();
      $rmodule = $request->has('rname') ? $request->rname : null;

      if (isset($plural)) {
        $results = DB::connection('dynamic')->select("Select concat(path ,'*',replace(replace(replace(replace(path,'" . $request->name . 's' . "','" . $request->plural . "'),'" . ucfirst($request->name) . 's' . "','" . ucfirst($request->plural) . "'),'" . $request->name . "','" . $request->rname . "'),'" . ucfirst($request->name) . "','" . ucfirst($request->rname) . "')) as path from paths where flag='" . $request->selectFlag . "' and path like '%" . $request->name . "%" . $request->extension ."' or path like '%" . $request->name . "%" . $request->extension ."x". "';");
        $resultsTranslation = DB::connection('dynamic')->select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
        $dbname = $request->dbname;
        return view('welcome', compact('results', 'action', 'data', 'replaced', 'module', 'plural', 'rmodule','selectFlag','resultsTranslation','dbname'));
      } else {
        $results = DB::connection('dynamic')->select("Select concat(path ,'*',replace(replace(path,'" . $request->name . "','" . $request->rname . "'),'" . ucfirst($request->name) . "','" . ucfirst($request->rname) . "')) as path from paths where flag='" . $request->selectFlag . "' and path like '%" . $request->name . "%" . $request->extension ."' or path like '%" . $request->name . "%" . $request->extension ."x". "';");


        $resultsTranslation = DB::connection('dynamic')->select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
        $dbname = $request->dbname;


        return view('welcome', compact('results', 'action', 'data', 'replaced', 'module', 'rmodule','resultsauto','selectFlag','resultsTranslation','dbname'));
      }
    }

    if ($request->action == '1' || $request->action == '3' || $request->action == '6' || $request->action == '20') {
      $action = $request->action == '1' ? 'Delete multible module' : ($request->action == '3' ? 'Open multible modules' : ($request->action == '20' ? 'Reblace word in module' : 'copy multible modules using repo'));


      // auto attributes (edit first methodology to avoid filling data)
      $attributes = explode(',', $request->attribute);
      $types = explode(',', $request->type);
      $replaceWords = ['undefined', 'Undefined'];
      $replacementWords = ['attribute', 'Attribute'];
      $module = $request->module;
      $resultsauto = [];
      $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration","dropMigration",'json'];
      
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
      // auto attributes (edit first methodology to avoid filling data)

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


      $results = DB::connection('dynamic')->select("select * from paths where flag='" . $request->selectFlag . "' and  (" . implode(" OR ", $sql) . ");");
      $repo = $request->repolink;
      $prepo = $request->projectrepolink;

      $word = $request->word;
      $replaceWord = $request->replaceWord;
      if($request->action!=6)
      $resultsTranslation = DB::connection('dynamic')->select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
       else
       $resultsTranslation=[];
      $dbname = $request->dbname;

      return view('welcome', compact('results', 'action', 'replaced', 'module', 'rmodule', 'repo', 'prepo', 'array', 'word', 'replaceWord','resultsauto','selectFlag','resultsTranslation','dbname'));
    }


    if ($request->action == '4') {
      $action = "Get files with size bigger than";
      $results = DB::connection('dynamic')->select("select * from paths where flag='" . $request->selectFlag . "' and path like '%.jpg%'");
      $size = $request->size;
      return view('welcome', compact('results', 'action', 'size', 'replaced', 'module','flag'));
    }
    if ($request->action == '5') {
      $action = "Show or Delete project images";
      // select database and add query
      $usedFiles = DB::connection('dynamic')->select("select db, id, url from (select '" . $request->dbname . "' as db, files.* from " . $request->dbname . ".files) as q;");
      $dbname = $request->dbname;


      return view('welcome', compact('usedFiles', 'action', 'replaced', 'module', 'dbname','flag'));
    }
    if ($request->action == '7') {
      $action = "translate all attributes";
      //show database attributes
      $results = DB::connection('dynamic')->select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");

      $dbname = $request->dbname;



    

      return view('welcome', compact('results', 'action', 'replaced', 'module', 'dbname','flag'));
    }

    if ($request->action == '8' || $request->action == '10') {
      $action = $request->action == '8' ? "Search all attributes at once" : "search project modules";
      $results = DB::connection('dynamic')->select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");
      $modules = DB::connection('dynamic')->select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");
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
      $modules = DB::connection('dynamic')->select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");
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




      $results = DB::connection('dynamic')->select("select * from paths where flag='" . $request->selectFlag . "' and (" . implode(" OR ", $sql) . ");");
      $results2 = DB::connection('dynamic')->select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");

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
      $modules = DB::connection('dynamic')->select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");
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
      $results = DB::connection('dynamic')->select("select distinct  TABLE_NAME,COLUMN_NAME,DATA_TYPE  from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");

      $tables = DB::connection('dynamic')->select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . $request->dbname . "'  order by TABLE_NAME;");
      $array = [];
      $array2 = [];
      $letters = [];
      $dataTypes=[];
      $counts=[];
      foreach ($tables as $table) {
        $string = '';
        $string2 = '';
        $datatype = '';
        $count = DB::connection('dynamic')->table($table->TABLE_NAME)->count();
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
        array_push($letters, $table->TABLE_NAME[$request->startingOrderLetter]);
        array_push($counts, $count);
      }

      $dbname = $request->dbname;



      $credential=DBCredential::where('db_name',isset($dbname)?$dbname:'yousabte_automation')->first();


      $startingOrderLetter=$request->startingOrderLetter;
      return view('welcome', compact('results', 'tables', 'action', 'replaced', 'module', 'array', 'dbname', 'letters', 'array2','dataTypes','queries','credential','counts','startingOrderLetter'));
    }

    if ($request->action == '13') {
      $action = "translate untranslated words";
      $results = DB::connection('dynamic')->select("select db, id, value,`key` from (select '" . $request->dbname . "' as db, ltm_translations.* from " . $request->dbname . ".ltm_translations where value IS NULL) as q;");
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


      $results = DB::connection('dynamic')->select("select * from paths where flag='" . $request->selectFlag . "' and (" . implode(" OR ", $sql) . ");");
      $commit = $request->commit;
      return view('welcome', compact('results', 'action', 'commit','flag'));
    }

    if ($request->action == '15') {
      if ($request->has('projectContent')) {
        $action = "add script";
        $contents = explode(".php:", $request->script);
        if (request()->has('overwrite'))
          DB::connection('dynamic')->table('projects')->truncate();
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
        if (true) {

            $searchRefrences = true;
            $sql = [];

            foreach ($array as $item) {
                $sql[] = "ai_prompt LIKE '%" . $item . "%'";
            }

            $query = implode(" AND ", $sql);

            // Issues and Projects already have `ai_prompt` column
            $issues = DB::select("SELECT *, 'issue' as source FROM issues WHERE $query ORDER BY id DESC");
            $projects = DB::select("SELECT *, 'project' as source FROM projects WHERE $query ORDER BY id DESC");

            // Scripts have 'script' column, alias it as 'ai_prompt'
            $scripts = DB::select("SELECT *, script as ai_prompt, 'script' as source FROM scripts WHERE " . implode(" AND ", array_map(function($item) {
                return "script LIKE '%$item%'";
            }, $array)) . " ORDER BY id DESC");

            // Merge all
            $results = array_merge($issues, $projects, $scripts);
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
      $action = "auto attributes (edit first methodology to avoid filling data)";
      $attributes = explode(',', $request->attribute);
      $types = explode(',', $request->type);
      $replaceWords = ['undefined', 'Undefined'];
      $replacementWords = ['attribute', 'Attribute'];
      $module = $request->module;
      $results = [];
      $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration","dropMigration",'json'];

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
    $content = $issue->ai_prompt;

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
    $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration","dropMigration",'json'];

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
  if ($request->action == '30') {
    $action = "ReactNative post";
    $baseUrl = $request->dbname;
    $component = $request->templateName;
    $function = $request->repolink;
    $attribute = $request->projectrepolink;
    $clientUrl = $request->commit;
    $endpoint = $request->word;

    // Fetch the issue data
    $issue = Issue::where('title', 'ReactNative post')->first();
    $content = $issue->ai_prompt;

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
    $titles = ["index1", "index2", "create", "edit", "show", "resource", "request", "model", "seeder", "migration","dropMigration",'json'];

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
  $content = $issue->ai_prompt;

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
  $content = $issue->ai_prompt;

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
    $content = $issue->ai_prompt;

    // Replace the specific URL with $baseUrl
    $content = str_replace('https://yousab-tech.com/academy/public/api', $baseUrl, $content);
    $content = str_replace('Courses', $component, $content);
    $content = str_replace('courses', $endpoint, $content);
    $results=[];
    return view('welcome', compact('action','results','content', 'flag'));
}
  if ($request->action == '31') {
    $action = "ReactNative get";
    $baseUrl = $request->dbname;
    $component = $request->templateName;
    $function = $request->repolink;
    $clientUrl = $request->commit;
    $endpoint = $request->word;

    // Fetch the issue data
    $issue = Issue::where('title', 'ReactNative get')->first();
    $content = $issue->ai_prompt;

    // Replace the specific URL with $baseUrl
    $content = str_replace('https://yousab-tech.com/academy/public/api', $baseUrl, $content);
    $content = str_replace('Courses', $component, $content);
    $content = str_replace('courses', $endpoint, $content);
    $results=[];
    return view('welcome', compact('action','results','content', 'flag'));
}
  
  
  

  }

public function execQuery(Request $request)
{
    try {
        $credential = DBCredential::where('db_name', $request->dbname ?? 'yousabte_automation')->first();
        $dbHost = isset($credential->db_host)?$credential->db_host:'192.185.41.219';
        $dbName = $credential->db_name ?? 'automation';
        $dbUser = $credential->db_username ?? 'root';
        $dbPass = $credential->db_password ?? '';

        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');

        $queryCommands = explode('++', $request->queryCommand);
            $query = Query::firstOrCreate(['title' => $request->queryCommand]);


        foreach ($queryCommands as $queryCommand) {
            $normalizedQuery = preg_replace('/\s+/', ' ', strtolower(trim($queryCommand, "; \t\n\r\0\x0B")));

            if (str_starts_with($normalizedQuery, 'update') && strpos($normalizedQuery, 'where') === false) {
                return response()->json([
                  'success' => "Add condition",
                  'data' => [],
              ]);
            }


            DB::connection('dynamic')->statement('use ' . $dbName);
            $data = DB::connection('dynamic')->select($queryCommand);

            $data = array_map(function ($row) {
                $row = (array) $row;
                if (isset($row['ai_prompt'])) {
                    $row['ai_prompt'] = preg_replace('/\s+/', ' ', $row['ai_prompt']);
                    $row['ai_prompt'] = trim($row['ai_prompt']);
                }
                if (isset($row['script'])) {
                    $row['script'] = preg_replace('/\s+/', ' ', $row['script']);
                    $row['script'] = trim($row['script']);
                }
                if (isset($row['dispatch_status'])) {
                    $row['dispatch_status'] = preg_replace('/\s+/', ' ', $row['dispatch_status']);
                    $row['dispatch_status'] = trim($row['dispatch_status']);
                }
                return $row;
            }, $data);

            $finalResult[] = [
                'query' => $queryCommand,
                'result' => $data,
            ];
        }


        return response()->json([
            'success' => "Done Successfully",
            'data' => $data,
        ]);
    } catch (\Exception $e) {
              return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'data' => [],
        ]);
    }
}




  /**
   * Display the specified resource.
   */
public function show($db, $table, $query)
{
    $credential = DBCredential::where('db_name', $db)->first();

    $dbHost = isset($credential->db_host)?$credential->db_host:'192.185.41.219';
    $dbName = $credential->db_name ?? 'automation';
    $dbUser = $credential->db_username ?? 'root';
    $dbPass = $credential->db_password ?? '';

    config([
        'database.connections.dynamic' => [
            'driver' => 'mysql',
            'host' => $dbHost,
            'database' => $dbName,
            'username' => $dbUser,
            'password' => $dbPass,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ]);

    DB::purge('dynamic');
    DB::reconnect('dynamic');
    DB::connection('dynamic')->statement('USE ' . $db);

    $queryData = ($query !== "null" && $query !== "") ? DB::connection('dynamic')->select($query) : null;

    $columns = DB::connection('dynamic')->select("
        SELECT COLUMN_NAME, DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", [$db, $table]);

    $excludedColumns = ['created_at', 'updated_at', 'id'];
    $filteredColumns = collect($columns)->filter(function ($column) use ($excludedColumns) {
        return !in_array($column->COLUMN_NAME, $excludedColumns);
    });

    $attributes = $filteredColumns->pluck('COLUMN_NAME')->implode(',');
    $datatypes = $filteredColumns->pluck('DATA_TYPE')->implode(',');

    $insertString = "INSERT INTO $table ($attributes) VALUES ($datatypes);";

    // Sort columns alphabetically
    $allColumnNames = collect($columns)->pluck('COLUMN_NAME')->sort()->values();
    $orderedColumnList = $allColumnNames->map(fn($col) => "`$col`")->implode(', ');

    $data = DB::connection('dynamic')->select("
        SELECT * 
        FROM (
            SELECT '" . $db . "' AS db, $orderedColumnList 
            FROM " . $db . "." . $table . "
            ORDER BY updated_at DESC
            LIMIT 1000
        ) AS q;
    ");

    // ✅ Clean ai_prompt / extra spaces / \n \r
    $data = array_map(function ($row) {
        $row = (array) $row;
        if (isset($row['ai_prompt'])) {
            $row['ai_prompt'] = preg_replace('/\s+/', ' ', $row['ai_prompt']);
            $row['ai_prompt'] = trim($row['ai_prompt']);
        }
        if (isset($row['script'])) {
            $row['script'] = preg_replace('/\s+/', ' ', $row['script']);
            $row['script'] = trim($row['script']);
        }
        if (isset($row['dispatch_status'])) {
            $row['dispatch_status'] = preg_replace('/\s+/', ' ', $row['dispatch_status']);
            $row['dispatch_status'] = trim($row['dispatch_status']);
        }
        return $row;
    }, $data);

    $updateQuery = "";

    if (request()->has('id')) {
        $id = request()->query('id');

        if (request()->has('delete')) {
            DB::connection('dynamic')
                ->table($table)
                ->where('id', $id)
                ->delete();
        }

        $singleRow = DB::connection('dynamic')->select("
            SELECT * 
            FROM (
                SELECT '" . $db . "' AS db, $orderedColumnList 
                FROM " . $db . "." . $table . "
                WHERE id = " . $id . "
            ) AS q;
        ");

        if (!empty($singleRow)) {
            $row = (array) $singleRow[0];

            $updateParts = [];
            foreach ($row as $column => $value) {
                if ($column !== 'db') {
                    $updateParts[] = "`$column` = " . DB::getPdo()->quote($value);
                }
            }

            $updateQuery = "
                UPDATE " . $db . "." . $table . "
                SET " . implode(', ', $updateParts) . "
                WHERE id = " . $id . ";
            ";
        }
    }

    $totalCount = DB::connection('dynamic')->select("
        SELECT COUNT(*) as count 
        FROM " . $db . "." . $table . ";
    ");
    
    $count = $totalCount[0]->count;

    $latestUpdatedAt = DB::connection('dynamic')->select("
        SELECT MAX(updated_at) as latest_updated_at 
        FROM " . $db . "." . $table . ";
    ");
    $latestUpdatedAt = $latestUpdatedAt[0]->latest_updated_at ?? null;

    return response()->json([
        'success' => trans('general.sent_successfully'),
        'data' => $data,
        'queryData' => $queryData,
        'count' => $count,
        'columns' => $columns,
        'insertString' => $insertString,
        'latestUpdatedAt' => $latestUpdatedAt,
        'updateQuery' => $updateQuery,
    ]);
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
      if ($website->deal == 0)
        $website->update(['deal' => 1]);
      else
        $website->update(['deal' => 0]);
    }
    if (request()->routeIs('website.toggle')) {
      if ($website->status == 0)
        $website->update(['status' => 1]);
      else
        $website->update(['status' => 0]);
    }

    return response()->json(['success' => trans('general.sent_successfully'), 'status' => $website->status,"cost"=>$website->cost]);
  }

  public function updatePosts(Request $request){
    $post=Project::find($request->post_id);
    $post->update(['ai_prompt'=>$request->ai_prompt]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }
  public function updateSamples(Request $request){
    $sample=sample::find($request->sample_id);
    $sample->update(['script'=>$request->script]);

    return response()->json(['success' => trans('general.created_successfully')]);

  }

  public function getTableColumns(Request $request)
  {
      $dbname = $request->input('dbname');
      $tablename = $request->input('tablename'); // Comma-separated string, e.g., "services,products"
  
      if (!$dbname || !$tablename) {
          return response()->json(['error' => 'Database name and table name(s) are required'], 400);
      }
  
      try {
          $tableNames = explode(',', $tablename); // Split the comma-separated table names
          $uniqueColumns = [];
  
          foreach ($tableNames as $table) {
              $columns = DB::select("SELECT COLUMN_NAME, DATA_TYPE 
                                     FROM INFORMATION_SCHEMA.COLUMNS 
                                     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?", [$dbname, trim($table)]);
  
              foreach ($columns as $column) {
                  // Add column name and data type if it's not already present
                  $uniqueColumns[$column->COLUMN_NAME] = $column->DATA_TYPE;
              }
          }
  
          // Prepare response strings
          $columnNames = array_keys($uniqueColumns); // Unique column names
          $dataTypes = array_values($uniqueColumns); // Corresponding data types
  
          return response()->json([
              'columns' => implode(',', $columnNames),
              'dataTypes' => implode(',', $dataTypes),
          ]);
      } catch (\Exception $e) {
          return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
      }
  }
  public function updateReferences(Request $request){
    $issue=Issue::find($request->issue_id);
    $issue->update(['ai_prompt'=>$request->ai_prompt]);

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
    $issue->update(['ai_prompt'=>$request->ai_prompt]);

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
        // yousabEmails();
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
