<div class="row">
    <form action="{{ route('filterStats') }}" method="post">
        @csrf
        <div>
            <input type="month" id="start" class="show form-control  bg-white"  name="start">
        </div>
        <button class="d-none btn btn-warning" type="submit" id="month">Submit</button>
      </form>
</div>
<div class="row">
    <div class="d-flex {{ count($data)>DayInMonth()/8*2?'text-danger' :'text-success' }} justify-content-center">
         <span class="  me-2">{{ count($data) }}/{{ DayInMonth()}} days</span>
         
        <span class="text-success"><i>{{ number_format(DayInMonth()/8*2, 2) }}/{{ DayInMonth()}} days (1/4)</i></span>

        <span class="{{(((number_format(((DayInMonth()/8*2)- count($data))*8/2, 2))))<0?'text-danger':'text-success' }} mx-2">{{((number_format(((DayInMonth()/8*2)- count($data))*8/2, 2))) }} days</span>

        
        <span class="text-warning mx-2">{{ htmlspecialchars((string)calculateAge('1997-10-22')['years']) . " years and " . htmlspecialchars((string)calculateAge('1997-10-22')['months']) . " months old."}}</span>
        <span class="{{ (((accountant()->payed - accountant()->fees)*0.6)/6000) -  workMonths()>0? 'text-success' : 'text-danger' }} mx-2">Average in {{ number_format(workMonths(),2) }} Months: {{ number_format((((accountant()->payed - accountant()->fees)*0.6)+accountantBoula()->payed - accountantBoula()->fees)/workMonths() )}} L.E</span>

        <span class="{{ (((accountant()->payed - accountant()->fees)*0.6)/6000) -  workMonths()>0? 'text-success' : 'text-danger' }}   mx-2">
            Coverage Time(Salary:6000): 

            {{ number_format(((((accountant()->payed - accountant()->fees)*0.6)+accountantBoula()->payed - accountantBoula()->fees)/6000) -  workMonths(),2)}} 
            
            Months</span>


     </div>
    
     <p class="text-secondary"><i>{{ date('Y-m-d', strtotime($last->last_time . ' + 4 days')) }} </i></p>
    @foreach ($data as $item)
        {{-- @if ($item->last_time == '2024-03-08')
            <p title="{{ $item->created_at }}" class="text-danger">{{ $item->last_time }}</p>
        @else --}}
            <p title="{{ $item->created_at }} See Browsing history on pc for accurate time" class="{{ statsColor($loop->index) }}">{{ $item->last_time }}</p>
        {{-- @endif   --}}
    @endforeach

    {{-- <hr>
    @foreach ($clicksByDay as $day => $clicks)
    <h5>{{ $day }}</h5> <!-- Display the date -->
    <ul>
        @foreach ($clicks as $click)
            <li class="list-unstyled">{{ \Carbon\Carbon::parse($click->clickTime)->format('H:i') }}</li> <!-- Display time only -->
        @endforeach
    </ul>
@endforeach --}}

</div>



@push('welcome')
    <script>
        $('#start').on('change',function(){
            $('#month').click();
        });
        $('#start').show();
        $('#start').removeClass('hide').addClass('show'); 
    </script>
@endpush