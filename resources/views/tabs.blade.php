<div class="">

    <div class="row">
    
    <button class="btn btn-outline-warning col-2" id="{{boula()?'home':''}}">home</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'removeColors':''}}">Reset</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'googlead':''}}">GANM</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'seo':''}}">SEO</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'routes':''}}">Routes</button>
        <button class="btn btn-outline-warning col-2" id="videos">Videos</button>
        
    </div>
    
    <div class="row">
        <button class="btn btn-outline-warning col-2 clickable-text" style="cursor: pointer;"  content="{{ activeWebsitesContent() }}" id="{{boula()?'stress':''}}">Stress</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'yousab':''}}">Yousab</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'issues':''}}">Refrences</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'phpMyAdmin':''}}">sql</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'backup':''}}">Backup</button>
        <div class="col-2">
            <form action="{{ route('logout') }}" method="POST" class="w-100">
                @csrf
                <button class="btn btn-outline-warning col-12" type="submit">Logout</button>
            </form>
        </div>
        
    </div>
    <div class="row d-flex justify-content-center">
        <button class="btn btn-outline-warning col-2" id="{{boula()?'updateDB':''}}">upDB</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'auto':''}}">Auto</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'updatedTables':''}}">updatedTables</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'DBCredentials':''}}">DB Credentials</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'close':''}}">colse</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'dashboard':''}}">Dashboard</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'navigations':''}}">Navigations</button>
        <button class="btn btn-outline-warning col-2" id="{{boula()?'excavations':''}}">Excavations</button>

    </div>

    
    {{-- <button class="btn btn-outline-warning col-2" id="{{boula()?'motahda':''}}">Motahda</button>
    <button class="btn btn-outline-warning col-1" id="{{boula()?'second':''}}">Second</button> --}}
    {{-- <button class="btn btn-outline-warning col-1" id="{{boula()?'temblates':''}}">Temblates</button> --}}
    {{-- <button class="btn btn-outline-warning col-1" id="{{boula()?'notes':''}}">Notes</button> --}}
    {{-- <button class="btn btn-outline-warning col-1" id="{{boula()?'servers':''}}">Tasks</button> --}}
    {{-- <button class="btn btn-outline-warning col-1" id="{{boula()?'googleads':''}}">GoogleAds</button> --}}
    {{-- <button class="btn btn-outline-warning col-1" id="{{boula()?'tasks':''}}">Tasks</button> --}}
    {{-- <button class="btn btn-outline-warning col-1" id="{{boula()?'autor':''}}">autor</button> --}}
</div>


