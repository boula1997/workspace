<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>one tab window browser</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.1-dist/js/bootstrap.min.js') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="icon" href="{{ settings()->logo }}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4-dark.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">

</head>

<style>
    /* Set the background and text color for the Select2 container */
    .select2-container--default .select2-selection--single {
        background-color: #333;
        /* Dark background */
        color: #fff;
        /* White text */
        border: 1px solid #555;
        /* Border color */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000000;
        /* White text */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #000000 transparent transparent transparent;
        /* White arrow */
    }

    /* Dropdown menu */
    .select2-container--default .select2-results>.select2-results__options {
        background-color: #000000;
        /* Dark background */
        color: #fff;
        /* White text */
    }

    /* Hover and selected option styles */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #000000;
        /* Slightly lighter for hover */
        color: #fff;
        /* White text */
    }

    /* Placeholder text */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #aaa;
        /* Light gray placeholder */
    }

    /* Clear button */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        color: #fff;
        /* White clear button */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #ffffff !important;
        line-height: 28px;
        background-color: black !important;
    }

    .select2-search--dropdown {
        display: block !important;
        padding: 0px !important;
    }

    .select2-container--default .select2-results__option--selected {
        background-color: #ffc107 !important;
        color: #000000 !important;
    }

    .select2-container--default .select2-results__option--selected:hover {
        background-color: #ffc107 !important;
        color: #000000 !important;
    }

    .select2-container--default .select2-results__option--selected:focus {
        background-color: #ffc107 !important;
        color: #000000 !important;
    }
</style>

<body>
    <div class="container-fluid">

        @include('tabs')

        @if (boula())
            <div class="allModals">
                @foreach (posts() as $post)
                    <div class="modal fade" id="postModal{{ $post->id }}" tabindex="-1"
                        aria-labelledby="postModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="postModalLabel{{ $post->id }}">
                                        {{ $post->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="postForm" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div>
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <textarea class="form-control  summernote" name="codeLinks" id="" cols="30" rows="10">{{ isset($post->codeLinks) ? $post->codeLinks : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif

        @if (boula())
            <div class="allReferences">
                @foreach (References() as $refrnce)
                    <div class="modal fade" id="referenceModal{{ $refrnce->id }}" tabindex="-1"
                        aria-labelledby="referenceModalLabel{{ $refrnce->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="referenceModalLabel{{ $refrnce->id }}">
                                        {{ $refrnce->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="referenceForm" method="refrnce">
                                    @csrf
                                    <div class="modal-body">
                                        <div>
                                            <input type="hidden" name="issue_id" value="{{ $refrnce->id }}">
                                            <textarea class="form-control  summernote" name="codeLinks" id="" cols="30" rows="10">{{ isset($refrnce->codeLinks) ? $refrnce->codeLinks : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif

        <div id="formBody" class="mt-5">
            <div class="text-white text-center">{{ startAndEndTime(settingFirst()->startTime)[0] }} -
                {{ startAndEndTime(settingFirst()->startTime)[1] }}</div>

            <div>
                <div class="modal fade" id="tasksModal" tabindex="-1" aria-labelledby="tasksModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tasksModalLabel">
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="tasksForm" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div>
                                        <textarea class="form-control  summernote" name="tasks" id="" cols="30" rows="30">{!! websitesActive() !!}</textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="startTimeCheck">
                <form id="startTimeForm" method="post">
                    <p>Set your start time of work today</p>
                    <input type="datetime-local" id="startTimeInput" class="form-control w-25"
                        name="startTimeInput">
                    <button type="submit" id="startTimeButton" class="d-none btn btn-success mt-2">Reset Start
                        Time</button>
                </form>
            </div>
            @include('success')
            {{-- @foreach (websites() as $website)
            <div class="modal fade" id="postModal{{ $website->id }}" tabindex="-1"
                aria-labelledby="postModalLabel{{ $website->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="postModalLabel{{ $website->id }}">
                                {{ $website->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="postForm" method="post">
                            @csrf
                            <div class="modal-body">
                                <div>
                                    <input type="hidden" name="post_id"
                                        value="{{ $website->id }}">
                                    <textarea class="form-control  summernote" name="tasks" id="" cols="30" rows="10">{{ isset($website->tasks) ? $website->tasks : '' }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach --}}
            <form method="post" id="form" action="{{ route('actions.store') }}">
                @csrf
                <div class="row">
                    <div class="mt-2" id="allWebsites">
                        <p>Choose websites you will work on today <span class="text-danger">Red</span>:Dealing <span
                                class="text-success">Green</span>:Finance <span
                                class="text-warning">Yellow</span>:Working on</p>
                        <div class="website-container d-flex flex-wrap">
                            @foreach (websites() as $website)
                                <p id="{{ $website->id }}" title="1click:yellow 2click:green 3click:red"
                                    class="{{ $website->deal ? ($website->status == 0 ? 'bg-secondary' : ($website->status == 1 ? 'bg-warning' : ($website->status == 2 ? 'bg-success' : 'bg-warning'))) : 'bg-danger' }}  hover-cursor mx-1 text-nowrap text-back">
                                    {{ $website->title }}</p>

                                <i style="cursor: pointer;" content="{{ $website->codeLinks }}"
                                    websiteId="{{ $website->id }}"
                                    class="clickable-text text-secondary fas fa-copy"></i>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-success w-100" id="amDone">I am
                            done!</button>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-2" id="allRefrences">
                        <div class="website-container d-flex flex-wrap">
                            @foreach (References() as $refrnce)
                                <button type="button" content="{{ $refrnce->codeLinks }}" id="{{ $refrnce->id }}"
                                    title="1click:yellow 2click:green 3click:red"
                                    class="clickable-text reference btn {{ $refrnce->status == 0 ? 'btn-outline-warning' : ($refrnce->status == 1 ? 'btn-outline-warning' : 'btn-success') }}  hover-cursor mx-1 text-nowrap m-2">{{ $refrnce->title }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-2" id="allRoutes">
                        <div class="website-container d-flex flex-wrap">
                            @foreach (websitesRoutes() as $website)
                                <a href="{{ $website->routesLink }}">
                                    <button type="button" content="{{ $website->codeLinks }}"
                                        id="{{ $website->id }}" title="1click:yellow 2click:green 3click:red"
                                        class="clickable-text btn {{ $website->status == 0 ? 'btn-outline-warning' : ($website->status == 1 ? 'btn-outline-warning' : 'btn-success') }}  hover-cursor mx-1 text-nowrap m-2">{{ $website->title }}</button>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    {{-- <h1 class="text-center">Automation</h1> --}}
                    <div>
                        <div class="modal fade" id="surveyModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="tasksModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tasksModalLabel"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    @if (boula())
                                        <div class="modal-body">
                                            <div>
                                                <p>Was the last time <span
                                                        class="text-white">{{ setting()->last_time }}
                                                        ({{ getTimeAgo(setting()->last_time) }})</span>?</p>
                                                <button id="yes" class="btn btn-success">Yes</button>
                                                <button id="no" type="button"
                                                    class="btn btn-danger">No</button>
                                                <input type="date" id="lastTimeDate" class="form-control w-25"
                                                    name="lastTimeDate">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <select name="action" class="form-control  text-white " id="selectAction">
                                    <option value="">Select the required action</option>
                                    <option class="" value="15">add script</option>
                                    <option class="" value="15">add module</option>
                                    <option value="23">auto attributes</option>
                                    <option value="0">create new module(or Open newly added module)</option>
                                    <option value="14">checkout multible module</option>
                                    <option value="6">copy multible modules using repo</option>
                                    <option value="12">desc database</option>
                                    <option value="1">Delete multible module</option>
                                    <option value="19">flags manager</option>
                                    <option value="16">get multible scripts</option>
                                    <option value="16">get multible modules</option>
                                    <option class="{{ boula() ? '' : 'myTab' }}" value="21">Get Stats</option>
                                    <option value="4">Get files with size bigger than</option>
                                    <option value="18">Image Workspace</option>
                                    <option value="3">Open multible modules</option>
                                    <option value="11">Open Shared Module Files</option>
                                    <option value="9">Prebare multible modules to work on</option>
                                    <option value="2">Rename module</option>
                                    <option value="20">Reblace word in module</option>
                                    <option value="5">Show or Delete project images</option>
                                    <option value="8">Search all attributes at once</option>
                                    <option value="10">search project modules</option>
                                    <option value="7">translate all attributes</option>
                                    <option value="13">translate untranslated words</option>
                                    <option value="25">React post</option>
                                    <option value="26">React get</option>
                                    <option value="28">Ajax get</option>
                                    <option value="29">Ajax post</option>
                                    {{-- <option value="22">Open Websites</option> --}}
                                    {{-- <option value="17">Servers Hostings and git default</option> --}}
                                    {{-- <option value="24">Add new template link</option>
                                    <option value="27">Add new googlead link</option> --}}
                                </select>
                            </div>


                            <div class="form-group mt-2">
                                <select name="extension" id="extension" class=" text-white">
                                    <option value=".php">php</option>
                                    <option value=".blade.php">blade</option>
                                    <option value="">Not</option>
                                    <option value=".js">js</option>
                                    <option value=".css">css</option>
                                    <option value=".html">html</option>
                                    <option value=".jpeg">jpeg</option>
                                    <option value=".png">png</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <input class=d-inline" value="" type="checkbox" name="showWebsites"
                                    id="showWebsites">
                                <p class="d-inline pointer-cursor">Show Websites</p>
                            </div>
                            @if (boula())
                                <div class="form-group mt-2">
                                    <input class=d-inline" value="" type="checkbox" name="showReferences"
                                        id="showReferences">
                                    <p class="d-inline pointer-cursor">Show Refernces</p>
                                </div>
                            @endif
                            <div class="form-group mt-2">
                                <input class=d-inline" value="" type="checkbox" name="showRoutes"
                                    id="showRoutes">
                                <p class="d-inline pointer-cursor">Show Routes</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=d-inline" value="" type="checkbox" name="showTasks"
                                    id="showTasks">
                                <p class="d-inline pointer-cursor">Show Tasks</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=d-inline" value="" type="checkbox" name="startYourWork"
                                    id="startYourWork">
                                <p class="d-inline pointer-cursor">Start Your Work</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=" d-inline" value="" type="checkbox" name="showSurvey"
                                    id="showSurvey">
                                <p class="d-inline pointer-cursor ">Show Survry</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=" d-inline" type="checkbox" name="replace" id="">
                                <p class="d-inline pointer-cursor">Would you like to update files paths or urls paths?
                                </p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=" d-inline" type="checkbox" name="overwrite" id="overwrite">
                                <p class="d-inline pointer-cursor">overwrite paths</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=" d-inline" type="checkbox" name="linkPHP" id="linkPHP">
                                <p class="d-inline pointer-cursor">get links out of php files</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=" d-inline" type="checkbox" name="searchRefrences"
                                    id="searchRefrences">
                                <p class="d-inline pointer-cursor">Search in Refrences</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=" d-inline" value="{{ old('refrence') }}" type="checkbox"
                                    name="refrence" id="refrencePlural">
                                <p class="d-inline pointer-cursor">does the plural name of refrence module
                                    is diffrent?</p>
                            </div>
                            <div class="form-group mt-2">
                                <input class=" d-inline" value="{{ old('refrence') }}" type="checkbox"
                                    name="projectContent" id="projectContent">
                                <p class="d-inline pointer-cursor">Do you mean project scripts?</p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            @include('websites')
                            <div class="form-group mt-2">
                                <input value="{{ old('name') }}" type="text" class="form-control   text-white"
                                    name="name" placeholder="name">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('newPaths') }}"
                                    class="form-control   text-white" name="newPaths" placeholder="New files paths">
                            </div>
                            <div class="form-group mt-2">
                                <select class="form-control   text-white" name="selectFlag" id="flaginput">
                                    <option value="">Select Flag</option>
                                    @foreach (flags() as $flag)
                                        <option value="{{ $flag->flag }}">{{ $flag->flag }}</option>
                                    @endforeach
                                </select>
                                <input type="text" value="{{ old('flag') }}" class="form-control   text-white"
                                    id="flaginput" name="flag"
                                    placeholder="paths flag ex:Reservya/ReservyaDashboardPortal or ReservyaDashboardPortal">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('templateName') }}"
                                    class="form-control   text-white" name="templateName"
                                    placeholder="Insert Template Name">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('googleadName') }}"
                                    class="form-control   text-white" name="googleadName"
                                    placeholder="Insert Googlead Name">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" class="form-control   text-white" name="rname"
                                    value="{{ old('rname') }}" placeholder="Insert need to create Module Name">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('plural') }}" class="form-control   text-white"
                                    name="plural" placeholder="Insert plural if diffrent">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('size') }}" class="form-control   text-white"
                                    name="size" placeholder="Insert file size">
                            </div>
                            <div class="form-group mt-2">
                                <input id="db_name" type="text" class="form-control   text-white"
                                    name="dbname" placeholder="Insert database name">
                            </div>
                            <div class="form-group mt-2">
                                <input id="tablename" type="text" class="form-control   text-white"
                                    name="tablename" placeholder="ex: tablename1,tablename2">
                            </div>

                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('repolink') }}"
                                    class="form-control   text-white" name="repolink" placeholder="Insert repo link">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('projectrepolink') }}"
                                    class="form-control   text-white" name="projectrepolink"
                                    placeholder="Insert project repo link">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('commit') }}" class="form-control   text-white"
                                    name="commit" placeholder="Insert commit">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('word') }}" class="form-control   text-white"
                                    name="word" placeholder="Insert word">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('replaceWord') }}"
                                    class="form-control   text-white" name="replaceWord"
                                    placeholder="Insert replaceWord">
                            </div>
                            <div class="form-group mt-2">
                                <input value="{{ old('attribute') }}" id="attributes" type="text"
                                    class="form-control   text-white" name="attribute" placeholder="item1,item2,...">
                            </div>
                            <div class="form-group">
                                <select name="stack" id="stack"
                                    class="form-control noHide bg-black text-white">
                                    <option value="">Select Stack</option>
                                    <option value="dashfastkart">DashFastKart</option>
                                    <option value="DashAloo">DashAloo</option>
                                    <option value="dashlaravel">Dashlaravel</option>
                                    <option value="frontlaravel">Frontlaravel</option>
                                    <option value="react">React</option>
                                    <option value="reactNative">ReactNative</option>
                                    <option value="template">Template</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" value="{{ old('module') }}" class="form-control   text-white"
                                    name="module" placeholder="Insert module">
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" id="attrtypes" value="{{ old('type') }}"
                                    class="form-control   text-white" name="type"
                                    placeholder="all,input,inputtrans,textarea,textareatrans,select,multiselect,radio,file,multifile,image,multimage">
                            </div>
                            <div class="form-group mt-2">
                                <textarea class="form-control   text-white" name="script" id="textarea"
                                    placeholder="ex: keyword1, keyword2, keyword3" cols="30" rows="20"></textarea>
                                {{-- <input type="text" class="form-control   text-white" name="script" placeholder="Insert script"> --}}
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">

                            <a class="me-2" target="__blank"
                                href="https://chat.openai.com/c/bb327029-d82c-4e59-84a4-99f351e43983">
                                <img src="https://cdn.oaistatic.com/_next/static/media/apple-touch-icon.59f2e898.png"
                                    height="50" alt="">
                            </a>
                            <img class="mt-2" src="{{ asset('images/easyhard.png') }}" height="50"
                                alt="doing tasks from easy to hard" title="doing tasks from easy to hard">
                            <button class="btn btn-secondary mt-2" id="submitbtn">Submit</button>


                        </div>
                    </div>
                    <div class="row mt-3">

                        <div class="col-md-6">
                            <p>
                                all-input-inputtrans-textarea-textareatrans-select-multiselect-staticselect-multistaticselect-radio-file-multifile-image-multimage-date-time-datetime-number-checkbox-email-tel-url
                            </p>
                            <p>It is very helpful to use logs in laravel to debug especially in case of api where you
                                need to see terminal or console of front. So always use it for tracing and debuging </p>
                            <p>
                                $total_price = $total_price - $discount;
                                Log::info("total_price => $total_price");

                            </p>
                            <p>Important: use stop record in network of inspect to catch a request before reloading</p>
                            <p>to avoid confusion when using tabs use ctrl+shift+pageup or pagedown to move tavb right
                                to the end and start add the new needed tab</p>
                            <p>use query that has orderby updated_at to easiloy find item you editted data in sql query
                            </p>
                            <p>cors or network error that prevents you from seeing the error may be because of bad
                                browser try another account or new browser</p>
                            <p class="text-warning">Listen to tasks and write most important of them in notebook (Most
                                Important)</p>
                            <p class="text-warning">alt +dblclick methodology + auto attributes automation option</p>
                            <ul class="text-white">
                                <li>
                                    write attributes on lines like this and copy them using alt+dblclick
                                    name
                                    email
                                    phone
                                </li>
                                <li>
                                    Custom module to have same number of attributes
                                </li>
                                <li>
                                    use alt+dblclick on attributes module that need to be changed and paste copied
                                    attributes got ftom step1
                                </li>
                                <li>
                                    use clippoard inputs to add missing number of inputs in module
                                </li>

                            </ul>
                            <hr>
                            <p class="text-warning">Use this script to have a console for websites on mobile. Just put
                                it in the website footer:</p>
                            <pre class="text-white">
                        &lt;script src="https://cdn.jsdelivr.net/npm/eruda"&gt;&lt;/script&gt;
                        &lt;script&gt;eruda.init();&lt;/script&gt;
                        </pre>

                            <p class="text-warning">windows+prntscrren - ctrl+v in whatsapp methodology</p>
                            <hr>
                            <p class="text-warning">Note:keep mobile out during working hours to avoid distractions</p>
                            <p>Note: when search for a migration use _migrationname to easily find it</p>
                            <p>Note: Enable debug tool in laravel by APP_DEBUG=true in .env file</p>
                            <p>Note: Use local server api if there is no network and for mobile use android studio to
                                run it without wifi</p>
                            <p>Make all supportive materials accessed from this app only</p>
                            <div class="text-justify text-white col-md-6">
                                Note: The system is working with procedure so you may need to do more than one option
                                and you
                                will find the order when you open them brcause they have note about the next step
                            </div>
                            <p class="mt-2">Note: use git ls-files</p>

                            <p class="mt-2">Note: It is essential to have a pen and a notebook on your desk</p>

                            <p>Ready to do magic {{ ':)' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h1>Alarm device every hour (you can import task from file here and also there the bat file
                                here)</h1>
                            <p>
                                Step 1: Create a Batch Script hourly_alarm.bat
                                @echo off
                                echo Alarm at the start of the hour!
                                powershell -c (New-Object Media.SoundPlayer "C:\Windows\Media\Alarm01.wav").PlaySync()

                                Step 2: Use Task Scheduler
                                Press Win + S, type Task Scheduler, and open it.
                                In Task Scheduler:
                                Select Create Basic Task from the right pane.
                                Name the task, e.g., "Hourly Alarm".
                                Choose Daily as the trigger.
                                Set the start time to the next hour and select Repeat task every 1 hour for the duration
                                of 1 day.
                                In the Action step, select Start a program and browse to your hourly_alarm.bat script.
                                Save the task.

                                Now, your alarm will play at the start of every hour. You can disable the task in Task
                                Scheduler if you no longer need it.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>if you want to change website lang change the default lang in programming to redirect to
                                it because links does not have the lang in url</p>
                            <p class="mt-2">Note: add the following code to web.php to get project file paths and add
                                them
                                then with project files when choosing update file paths</p>
                            <p>if project iss <span class="text-warning">html</span> template you do not need to do
                                anything just add the project file paths</p>
                            <p>if project is <span class="text-warning">React</span> you need to copy all the routes
                                files that mostly has name App.jsx</p>
                            <p>Create a .env file at your project root and specify port number there. Like PORT=5173</p>
                        </div>
                    </div>
                    <div class="row">
                        <p class="text-warning">Productivity Solution</p>
                        <p>Get titles need to get money ordered by piority and paste them in note app on mobile and
                            take
                            a screen shot and set it as lockscreen wallpaper on mopile</p>
                        <p>Cutrrent </p>
                        <p>Kareem - Armya</p>
                        <p>Hassan - Beshoy</p>
                        <p>Future</p>
                        <p>Belal - Mina - Medhat</p>
                    </div>

                    <div class="row">
                        <p class="text-warning">Testing script: to continously submit forms and see validations</p>
                        <p>It is used with multi open links or link by link when using routes to
                            see links and choose only used links to test or open all links</p>
                        <code>
                            $(document).ready(function(){
                            if (window.location.href.includes(&quot;localhost/&quot;)) {
                            setTimeout(function() {
                            // Check if the body does not contain any tables
                            if ($(&#39;body&#39;).find(&#39;table&#39;).length === 0) {
                            $(&#39;form&#39;).each(function() {
                            var action = $(this).attr(&#39;action&#39;);
                            var method = $(this).attr(&#39;method&#39;);

                            if (action !== &quot;&#123;&#123; route(&#39;logout&#39;) &#125;&#125;&quot;) {
                            $(this).find(&#39;button[type=&quot;submit&quot;]&#39;).not(&#39;.btn.btn-navbar&#39;).each(function()
                            {
                            $(this).click(); // Trigger the click event
                            });
                            }
                            });
                            }
                            }, 10000); // 10,000 milliseconds = 10 seconds
                            }
                            });
                            &lt;/code&gt;
                        </code>

                    </div>
                    <div class="row mt-5">
                        <p class="text-warning">Always use poweshell because it has memeory</p>
                        <div class="col-md-6">
                            <p class="text-warning">Pined Clipboard elements</p>
                            <code>
                                if (App::environment('local')) {
                                Route::get(&#39;routes&#39;, function () {
                                $routeCollection = Route::getRoutes();

                                echo &quot;&lt;table style=&#39;width:100%; border: 1px solid black; border-collapse:
                                collapse;&#39;&gt;&quot;;
                                echo &quot;&lt;tr&gt;&quot;;
                                echo &quot;&lt;th style=&#39;border: 1px solid black;&#39;&gt;HTTP
                                Method&lt;/th&gt;&quot;;
                                echo &quot;&lt;th style=&#39;border: 1px solid black;&#39;&gt;Route&lt;/th&gt;&quot;;
                                echo &quot;&lt;th style=&#39;border: 1px solid black;&#39;&gt;Name&lt;/th&gt;&quot;;
                                echo &quot;&lt;th style=&#39;border: 1px solid black;&#39;&gt;Corresponding
                                Action&lt;/th&gt;&quot;;
                                echo &quot;&lt;/tr&gt;&quot;;

                                foreach ($routeCollection as $value) {
                                echo &quot;&lt;tr&gt;&quot;;
                                echo &quot;&lt;td style=&#39;border: 1px solid black;&#39;&gt;&quot; .
                                $value-&gt;methods()[0] . &quot;&lt;/td&gt;&quot;;
                                echo &quot;&lt;td style=&#39;border: 1px solid black;&#39;&gt;&quot; . $value-&gt;uri()
                                . &quot;&lt;/td&gt;&quot;;
                                echo &quot;&lt;td style=&#39;border: 1px solid black;&#39;&gt;&quot; .
                                ($value-&gt;getName() ?? &#39;N/A&#39;) . &quot;&lt;/td&gt;&quot;;
                                echo &quot;&lt;td style=&#39;border: 1px solid black;&#39;&gt;&quot; .
                                $value-&gt;getActionName() . &quot;&lt;/td&gt;&quot;;
                                echo &quot;&lt;/tr&gt;&quot;;
                                }

                                echo &quot;&lt;/table&gt;&quot;;
                                });
                                }

                            </code>
                            </code>
                            <br>
                            <hr class="text-white">
                            <p title="auto fill password">Pa$$w0rd!</p>
                            <br>
                            <hr class="text-white">
                            <p title="Pa$$w0rd!">"$2y$10$KGRWYA9/eCPF5rwZ0vx4GevysNBDNrvlVtmsxiSTDRhtLeExnnoXi"</p>
                            <br>
                            <hr class="text-white">

                            <code>
                                &#123;
                                &quot;name&quot;: &quot;John Doe&quot;,
                                &quot;phone&quot;: &quot;+201234567890&quot;,
                                &quot;email&quot;: &quot;john.doe@example.com&quot;,
                                &quot;address&quot;: &quot;1234 Main St, Cairo, Egypt&quot;,
                                &quot;totalPrice&quot;: 150.00,
                                &quot;items&quot;: [
                                &#123;
                                &quot;id&quot;: 1,
                                &quot;qty&quot;: 2,
                                &quot;totalPrice&quot;: 50.00,
                                &quot;for_agency&quot;: 1
                                &#125;,
                                &#123;
                                &quot;id&quot;: 2,
                                &quot;qty&quot;: 1,
                                &quot;totalPrice&quot;: 50.00,
                                &quot;for_agency&quot;: 0
                                &#125;
                                ]
                                &#125;
                            </code>
                            <br>
                            <hr class="text-white">

                            <p>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</p>
                            <br>
                            <hr class="text-white">
                            <p>2JCoIkhAyWRqrzdy</p>
                            <br>
                            <hr class="text-white">
                            <p>ssh yousabte@192.185.41.219 -p2222</p>
                            <br>
                            <hr class="text-white">

                            <p>cd %USERPROFILE%\Desktop</p>
                            <p>start postman</p>
                            <p>start WNetWatcher</p>
                            <p> cd /d E:/xampp/mysql/bin</p>
                            <p> mysqldump -u root -p --no-create-info --ignore-table=automation.migrations automation >
                                "E:/xampp/htdocs/workspace/exported_databases/automation.sql</p>
                            <p>cd /d E:\xampp\htdocs\automation</p>
                            <p>git add .</p>
                            <p>git commit -m "commit"</p>
                            <p>git pull origin main</p>
                            <p>git push origin main</p>
                            <p>start http://127.0.0.1:9000/</p>
                            <p>php artisan ser --port=9000</p>
                            <p>cls</p>
                            <br>
                            <hr class="text-white">
                            <p>request()->segment(count(request()->segments()))</p>
                            <br>
                            <hr class="text-white">
                            <p>@echo off</p>
                            <p>rem Save the current working directory</p>
                            <p>set CURRENT_DIR=%cd%</p>
                            <p>rem Navigate to the automation project directory</p>
                            <p>cd /d E:\xampp\htdocs\automation</p>
                            <p>rem Run the export databases script</p>
                            <p>call export_each_database.bat</p>
                            <p>git add .</p>
                            <p>git commit -m "commit"</p>
                            <p>git pull origin main</p>
                            <p>git push origin main</p>
                            <p>rem Return to the original directory</p>
                            <p>cd /d %CURRENT_DIR%</p>
                            <p>rem Run Laravel migrate fresh with seed in the erp project directory</p>
                            <p>php artisan migrate:fresh</p>
                            <p>start http://localhost/phpmyadmin/index.php?route=/</p>
                            <p>cls</p>
                            <br>
                            <hr class="text-white">
                            <p>git add .</p>
                            <p>git commit -m "commit"</p>
                            <p>git pull origin main</p>
                            <p>git push origin main</p>
                            <p>cls</p>
                        </div>
                    </div>


                </div>

            </form>
        </div>
        <div id="result" class="text-white">
            <button class="btn btn-warning w-100 d-none fixed-top text-right" id="showForm"><span
                    id="addFormStyle">Show
                    form</span></button>
            <div class="d-flex justify-content-start">
                <button id="refresh" class="btn btn-secondary w-75 fixed-top text-right d-none mt-5"><span
                        class="mx-5" style="margin-right: -600px !important">Refresh</span></button>
            </div>
            <div class="d-flex justify-content-start">
                <button id="allResults"
                    class="btn btn-success d-none w-50 fixed-top text-right right-0 ms-5 ps-5 mt-5"><span
                        style="margin-right: -200px !important">Show All</span></button>
            </div>

            @include('result')
        </div>
    </div>

    <div class="" id="data" today="{{ todayDate() }}" tomorrow="{{ tomorrow() }}"></div>
    <div class="" id="codeCreate" code="{{ codes()->createView }}"></div>
    <div class="" id="codeShow" code="{{ codes()->showView }}"></div>
    <div class="" id="codeIndex" code="{{ codes()->indexView }}"></div>

    <!-- Start button WhatsApp -->
    {{-- <a id="whats" class="whats" href="http://127.0.0.1:9000/" >
        <div style="width: 40px;">

        </div>
    </a> --}}
    @include('navIcon')


</body>

@include('scripts')


</html>
