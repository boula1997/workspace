<!DOCTYPE html>
<html>

<head>
    <title>Websites</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.1-dist/js/bootstrap.min.js') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4-dark.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/file.jpg') }}">
    @livewireStyles

</head>


<style>
    .note-toolbar {
    z-index: 9999; /* Set a high z-index value */
}
    .clickable-text {
        cursor: pointer;
    }

    body {
        overflow-y: hidden;
        background-color: black;
    }

    .whats {
        position: fixed;
        top: 5%;
        left: 1%;
        z-index: 200;
        display: inline-block;
        border: none !important;
        outline: none !important;
        background-color: #FFC107;
        cursor: pointer;
        padding: 18px 0.5px;
        border-radius: 50%;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        -webkit-box-shadow: 2px 2px 5px #b0afaf, -2px -2px 5px #b0afaf;
        box-shadow: 2px 2px 5px #b0afaf, -2px -2px 5px #b0afaf;
    }

    .whats:hover {
        -webkit-box-shadow: 2px 2px 5px #7a7979, -2px -2px 5px #7a7979;
        box-shadow: 2px 2px 5px #7a7979, -2px -2px 5px #7a7979;
    }

    .whats i {
        font-size: 45px;
        color: #fff;
    }


    ::placeholder {
        color: #fff !important;
    }

    :focus {
        background-color: black;
        color: #fff !important;
    }

    input {
        background-color: black !important;
        color: #fff !important;
    }

    textarea {
        background-color: black !important;
        color: #fff !important;
    }

    .card {
        background-color: black !important;
        color: rgb(255, 255, 255) !important;

    }

    .modal-header {
        background-color: black !important;
        color: #fff !important;
    }

    .modal-body {
        background-color: black !important;
        color: #fff !important;
    }

    .modal-footer {
        background-color: black !important;
        color: #fff !important;
    }
</style>

<body>
    <div class="container-fluid overflow-y-hidden">
        @include('tabs')
        <div class="row justify-content-center">
            {{-- <div class="allModals">
                @foreach (accounts() as $account)
                    <div class="modal fade" id="accountModal{{ $account->id }}" tabindex="-1"
                        aria-labelledby="accountModalLabel{{ $account->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="accountModalLabel{{ $account->id }}">
                                        {{ $account->client }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="accountForm" method="account">
                                    @csrf
                                    <div class="modal-body">
                                        <div>
                                            <input type="hidden" name="account_id" value="{{ $account->id }}">
                                            <textarea class="form-control  summernote" name="tasks" id="" cols="30" rows="10">{{ isset($account->tasks) ? $account->tasks : '' }}</textarea>
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
            </div> --}}
            <div class="card ">
                <div class="card-header text-center">
                    <h2 class="text-white">Websites</h2>
                </div>
                <div class="card-body ">
                    @include('done')
                    @livewire('accounts')
                </div>
            </div>
        </div>
    </div>

    <div id="startTime" startTime={{ getHourFromDateTime(settingFirst()->startTime) }}></div>

    <!-- Start button WhatsApp -->
    {{-- <a id="whats" class="whats" href="http://127.0.0.1:9000/" >
        <div style="width: 40px;">

        </div>
    </a> --}}
    @livewireScripts
    @include('scripts')
</body>

</html>
