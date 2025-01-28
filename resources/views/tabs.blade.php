<div class="">

    <div class="row">
    
        <button class="btn btn-outline-warning col-2" id="home">home</button>
        <button class="btn btn-outline-warning col-2" id="removeColors">Reset</button>
        <button class="btn btn-outline-warning col-2" id="googlead">GANM</button>
        <button class="btn btn-outline-warning col-2" id="seo">SEO</button>
        <button class="btn btn-outline-warning col-2" id="routes">Routes</button>
        <button class="btn btn-outline-warning col-2" id="meet">Meet</button>
        
    </div>
    
    <div class="row">
        <button class="btn btn-outline-warning col-2 clickable-text {{boula()?'':'myTab'}}" style="cursor: pointer;"  content="{{ activeWebsitesContent() }}" id="stress">Stress</button>
        <button class="btn btn-outline-warning col-2 {{boula()?'':'myTab'}}" id="yousab">Yousab</button>
        <button class="btn btn-outline-warning col-2 {{boula()?'':'myTab'}}" id="issues">Refrences</button>
        <button class="btn btn-outline-warning col-2 {{boula()?'':'myTab'}}" id="phpMyAdmin">sql</button>
        <button class="btn btn-outline-warning col-2 {{boula()?'':'myTab'}}" id="backup">Backup</button>
        <div class="col-2">
            <form action="{{ route('logout') }}" method="POST" class="w-100">
                @csrf
                <button class="btn btn-outline-warning col-12" type="submit">Logout</button>
            </form>
        </div>
        
    </div>
    <div class="row d-flex justify-content-center">
        <button class="btn btn-outline-warning col-2" id="updateDB">upDB</button>
        <button class="btn btn-outline-warning col-2" id="auto">Auto</button>
        <button class="btn btn-outline-warning col-2" id="updatedTables">updatedTables</button>
        <button class="btn btn-outline-warning col-2" id="DBCredentials">DB Credentials</button>
        <button class="btn btn-outline-warning col-2" id="close">colse</button>
        <button class="btn btn-outline-warning col-2" id="dashboard">Dashboard</button>
    </div>
    
    {{-- <button class="btn btn-outline-warning col-2 {{boula()?'':'myTab'}}" id="motahda">Motahda</button>
    <button class="btn btn-outline-warning col-1 {{boula()?'':'myTab'}}" id="second">Second</button> --}}
    {{-- <button class="btn btn-outline-warning col-1 {{boula()?'':'myTab'}}" id="temblates">Temblates</button> --}}
    {{-- <button class="btn btn-outline-warning col-1 {{boula()?'':'myTab'}}" id="notes">Notes</button> --}}
    {{-- <button class="btn btn-outline-warning col-1 {{boula()?'':'myTab'}}" id="servers">Tasks</button> --}}
    {{-- <button class="btn btn-outline-warning col-1 {{boula()?'':'myTab'}}" id="googleads">GoogleAds</button> --}}
    {{-- <button class="btn btn-outline-warning col-1 {{boula()?'':'myTab'}}" id="tasks">Tasks</button> --}}
    {{-- <button class="btn btn-outline-warning col-1 {{boula()?'':'myTab'}}" id="autor">autor</button> --}}
</div>


