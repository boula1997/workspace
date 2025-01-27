<div>
    <style>
        .note-toolbar {
            z-index: 9999;
            /* Set a high z-index value */
        }

        .overflow-auto {
            height: calc(100vh - 200px);
            /* Adjusted height to account for layout */
            overflow-y: auto;
            /* Ensures the table scrolls if content overflows */
            margin-bottom: 200px;
            /* Adds space below the table */
        }
    </style>
    @include('done')
    <div class="row">
        <div class="col-md-4">
            @if ($updateMode)
                @include('livewire.updateSample')
            @else
                @include('livewire.createSample')
            @endif
        </div>
        <div class="col-md-8 overflow-auto">

            <div class="row">
                <div class="col-md-6">
                    <label for="moduleInput">Module Value:</label>
                    <input type="text" id="moduleInput" value="module">
                </div>
                <div class="col-md-6">
                    <label for="attributeInput">Attribute Value:</label>
                    <input type="text" id="attributeInput" value="attribute">
                </div>
            </div>
            <table id="example1" class="table  table-hover table-dark table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Stack</th>

                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($samples as $sample)
                        <tr>
                            <td>{{ $sample->id }}</td>
                            <td>{{ $sample->title }}</td>
                            <td>{{ $sample->type }}</td>
                            <td>{{ $sample->stack }}</td>

                            <td>
                                {{-- <button wire:click="edit({{ $sample->id }})"
                                    class="btn btn-outline-primary btn-sm">Edit</button>
                                    
                                    <button class="btn btn-outline-warning btn-sm clickable-text" content="{{ $sample->script }}">Copy</button> --}}

                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $sample->id }}">
                                    Delete
                                </button>

                                <div class="modal fade" id="exampleModal{{ $sample->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel{{ $sample->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title " id="exampleModalLabel{{ $sample->id }}">
                                                    {{ $sample->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Are you sure you want to delete this script?<br><br>
                                                    <span class="text-secondary text-limit" style="--lines:3;">
                                                        {{ $sample->title }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal"
                                                    wire:click="delete({{ $sample->id }})">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#sampleModal{{ $sample->id }}">
                                    Modify
                                </button>

                                <div class="modal fade" id="sampleModal{{ $sample->id }}" tabindex="-1"
                                    aria-labelledby="sampleModalLabel{{ $sample->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sampleModalLabel{{ $sample->id }}">
                                                    {{ $sample->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="sampleForm" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div>
                                                        <input type="hidden" name="sample_id"
                                                            value="{{ $sample->id }}">
                                                        <textarea class="form-control  summernote" name="script" id="" cols="30" rows="10">{{ isset($sample->script) ? $sample->script : '' }}</textarea>
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
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


</div>
