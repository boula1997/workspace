<div class="row">
    @foreach ($flags as $flag)
        <div class="col-md-3">
            <form method="post" id="{{ $flag->flag }}" class="flag">
                @csrf
                @method('delete')
                <button type="button" class="btn btn-danger d-inline m-1" data-bs-toggle="modal"
                    data-bs-target="#exampleModal{{ $flag->flag }}">
                    {{ $flag->flag }}
                </button>

                <div class="modal fade" id="exampleModal{{ $flag->flag }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title " id="exampleModalLabel">Delete Flag
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p >
                                    Are you sure you want to Delete this flag?
                                    <span class="text-secondary text-limit" style="--lines:3;">
                                        {{ $flag->flag }}
                                    </span>
                                </p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endforeach
</div>
