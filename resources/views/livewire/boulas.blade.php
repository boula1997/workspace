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
        @if (!request()->routeIs('notes'))
            <div class="col-md-3">
                @if ($updateMode)
                    @include('livewire.update')
                @else
                    @include('livewire.create')
                @endif

                <div class="d-flex justify-content-between align-items-center  mt-1">
                    <p class="text-white mt-2 px-1" title="cost">C:{{ accountantBoula()->cost }}</p>
                    <p class="text-success mt-2 px-1" title="payed">P:{{ accountantBoula()->payed }}</p>
                    <p class="text-danger mt-2 px-1" title="debit">D:{{ accountantBoula()->cost - accountantBoula()->payed }}</p>
                    <p class="text-warning mt-2 px-1" title="fees">F:{{ accountantBoula()->fees }}</p>
                    <p class="text-info mt-2 px-1" title="profit">Pr:{{ accountantBoula()->payed - accountantBoula()->fees }}</p>
                </div>
            </div>
        @endif
        <div class="{{ request()->routeIs('notes') ? 'd-flex justify-content-center row' : 'col-md-9' }} overflow-auto">

            <div class="{{ request()->routeIs('notes') ? 'col-md-8 d-flex-justify-content-center' : '' }}">
                <table id="example1" class="table  table-hover table-dark table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th width="200px">title</th>
                            @if (!request()->routeIs('notes'))
                                <th>Cost</th>
                                <th>Payed</th>
                                <th>Debit</th>
                                <th>Fees</th>
                                {{-- <th>Lat Payed</th> --}}
                                <th>Days</th>
                                @endif
                                <th>Deal</th>
                                <th>Deadline </th>
                                <th>Status </th>
                            <th > <button type="button" content="{{ $combinedai_prompt }}"
                                    class="w-100 btn btn-outline-danger btn-sm browse">
                                    Prepare All
                                </button></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boulas as $boula)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ Str::limit($boula->title, 25) }}</td>
                                @if (!request()->routeIs('notes'))
                                    {{-- title="{{ getTimeAgo($boula->updated_at) }}" --}}
                                    <td>{{ $boula->cost }}</td>
                                    <td class="text-success">{{ $boula->payed }}</td>
                                    <td class="text-danger">{{ $boula->cost - $boula->payed }}</td>
                                    <td>{{ $boula->fees }}</td>
                                    <td  class="{{ countDaysSince($boula->lastTransaction) > 30 &&  ($boula->payed!=$boula->cost || $boula->cost==0)  ? 'text-danger' : '' }}">{{ countDaysSince($boula->lastTransaction) }}</td>
                                    {{-- <td>{{ getTimeAgo($boula->updated_at) }}</td> --}}
                                @endif
                                <td><p style="cursor: pointer;" class="text-decoration-none {{ $boula->deal?'text-success':'text-danger' }} toggleBoulaDeal" id="{{ $boula->id }}">{{ $boula->deal?'Yes':'No' }}</></td>

                                <td class="{{ $boula->deadline < date('Y-m-d') ? 'text-warning ' : '' }}">
                                    {{ $boula->deadline }}</td>

                                    <td class="{{ $boula->payed==$boula->cost?'text-success':'text-danger' }}">{{ $boula->payed==$boula->cost?'Payed':'Not Payed' }}</td>

                                <td>
                                    <button wire:click="edit({{ $boula->id }})"
                                        class="btn btn-outline-primary btn-sm">E</button>




                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $boula->id }}">
                                        D
                                    </button>

                                    <div class="modal fade" id="exampleModal{{ $boula->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel{{ $boula->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel{{ $boula->id }}">
                                                        {{ $boula->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Are you sure you want to delete this script?<br><br>
                                                        <span class=text-limit" style="--lines:3;">
                                                            {{ $boula->title }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger"
                                                        data-bs-dismiss="modal"
                                                        wire:click="delete({{ $boula->id }})">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#boulaModal{{ $boula->id }}">
                                        D
                                    </button>

                                    <div class="modal fade" id="boulaModal{{ $boula->id }}" tabindex="-1"
                                        aria-labelledby="boulaModalLabel{{ $boula->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="boulaModalLabel{{ $boula->id }}">
                                                        {{ $boula->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form id="boulaForm" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div>
                                                            <input type="hidden" name="boula_id"
                                                                value="{{ $boula->id }}">
                                                            <textarea class="form-control  summernote" name="tasks" id="" cols="30" rows="5">{{ isset($boula->tasks) ? $boula->tasks : '' }}</textarea>
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
                                    </div> --}}
                                    <button type="button" content="{{ $boula->ai_prompt }}"
                                        class="btn btn-outline-danger btn-sm browse">
                                        P
                                    </button>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
