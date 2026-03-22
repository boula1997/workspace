<div>
    <style>
            .note-toolbar {
    z-index: 9999; /* Set a high z-index value */
}
        .overflow-auto {
            height: calc(100vh - 100px);
            /* Adjust this value as per your layout */
            /* You may also add additional styling here as per your requirement */
        }
    </style>
    @include('done')
    <div class="row">
        <div class="col-md-4">
            @if ($updateMode)
                @include('livewire.updateNote')
            @else
                @include('livewire.createNote')
            @endif
        </div>
        <div class="col-md-8 overflow-auto">


            <table  class="table  table-hover table-dark table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Note</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $note->title }}</td>
                            <td>
                                <button wire:click="edit({{ $note->id }})"
                                    class="btn btn-outline-primary btn-sm">Edit</button>




                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $note->id }}">
                                    Delete
                                </button>

                                <div class="modal fade" id="exampleModal{{ $note->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel{{ $note->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title "
                                                    id="exampleModalLabel{{ $note->id }}">
                                                    {{ $note->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p >
                                                    Are you sure you want to delete this script?<br><br>
                                                    <span class="text-secondary text-limit" style="--lines:3;">
                                                        {{ $note->title }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal"
                                                    wire:click="delete({{ $note->id }})">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#noteModal{{ $note->id }}">
                                    Desc
                                </button>

                                <div class="modal fade" id="noteModal{{ $note->id }}" tabindex="-1"
                                    aria-labelledby="noteModalLabel{{ $note->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-white"
                                                    id="noteModalLabel{{ $note->id }}">
                                                    {{ $note->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="noteForm" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div>
                                                        <input type="hidden" name="note_id" value="{{ $note->id }}">
                                                        <textarea class="form-control" name="ai_prompt" id="" cols="30" rows="5">{{ $note->ai_prompt }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success"
                                                     >Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- {!! $notes->links('paginate') !!} --}}

                </tbody>
            </table>
        </div>
    </div>


</div>


