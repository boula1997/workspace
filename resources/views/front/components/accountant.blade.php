    {{-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
{{-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
    .accountant-icon {
        font-size: 2em !important;
        margin-top: 10%;
        color: white;
    }

    .accountant-h2 {
        color: white;
    }

    /* .intro {
  height: auto;
  min-height: 100vh;
  text-align: center;
  background-color: teal;
} */

</style>
<script>
    function inVisible(element) {
        //Checking if the element is
        //visible in the viewport
        var WindowTop = $(window).scrollTop();
        var WindowBottom = WindowTop + $(window).height();
        var ElementTop = element.offset().top;
        var ElementBottom = ElementTop + element.height();
        //animating the element if it is
        //visible in the viewport
        if ((ElementBottom <= WindowBottom) && ElementTop >= WindowTop)
            animate(element);
    }

    function animate(element) {
        //Animating the element if not animated before
        if (!element.hasClass('ms-animated')) {
            var maxval = element.data('max');
            var html = element.html();
            element.addClass("ms-animated");
            $({
                countNum: element.html()
            }).animate({
                countNum: maxval
            }, {
                //duration 5 seconds
                duration: 5000,
                easing: 'linear',
                step: function () {
                    element.html(Math.floor(this.countNum) + html);
                },
                complete: function () {
                    element.html(this.countNum + html);
                }
            });
        }

    }

    //When the document is ready
    $(function () {
        //This is triggered when the
        //user scrolls the page
        $(window).scroll(function () {
            //Checking if each items to animate are
            //visible in the viewport
            $("h2[data-max]").each(function () {
                inVisible($(this));
            });
        })
    });

</script>

<div class="container-fluid text-center">
    {{-- <h1>Some cool facts</h1> --}}
    <div class="row pt-5">
        @foreach ($accountants as $accountant)
        <div class="col-sm-3 pt-3 pb-4" style="background-color: #00FF00">
            <h2 class="accountant-h2" data-max="{{$accountant->count}}"></h2>
            <h2 class="accountant-h2">{{$accountant->title}}</h2>
        </div>
            
        @endforeach
    </div>
</div>
