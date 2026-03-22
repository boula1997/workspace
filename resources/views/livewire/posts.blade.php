<div>
    <style>
        .note-toolbar {
            z-index: 9999;
            /* Set a high z-index value */
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
                    <p class="text-white mt-2 px-1" title="cost">C:{{ accountant()->cost }}</p>
                    <p class="text-success mt-2 px-1" title="payed">P:{{ accountant()->payed }}</p>
                    <p class="text-danger mt-2 px-1" title="debit">D:{{ accountant()->cost - accountant()->payed }}</p>
                    <p class="text-warning mt-2 px-1" title="fees">F:{{ accountant()->fees }}</p>
                    <p class="text-info mt-2 px-1" title="profit">Pr:{{ accountant()->payed - accountant()->fees }}</p>
                </div>
            </div>
        @endif
        <div class="{{ request()->routeIs('notes') ? 'd-flex justify-content-center row' : 'col-md-9' }} overflow-auto">

            <div class="{{ request()->routeIs('notes') ? 'col-md-8 d-flex-justify-content-center' : '' }}">
                <button onclick="exportTableToExcel('tableID', 'accounts')">Export to Excel</button>
                <table id="tableID" class="table  table-hover table-dark table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th width="120px" class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('title')">title</th>
                            @if (!request()->routeIs('notes'))
                                <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('cost')">Cost</th>
                                <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('payed')">Payed</th>
                                <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('debit')">Debit</th>
                                <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('fees')">Fees</th>
                                {{-- <th>Lat Payed</th> --}}
                                <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('lastTransaction')">Days</th>
                                <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('status')">Status </th>
                            @endif
                            <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('deal')">Deal</th>
                            <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('appearance')">Show</th>
                            <th class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('deadline')">Deadline </th>
                            <th> <button type="button" content="{{ $combinedai_prompt }}"
                                    class="w-100 btn btn-outline-danger btn-sm browse">
                                    Prepare All
                                </button></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ Str::limit($post->title, 15) }}</td>
                                @if (!request()->routeIs('notes'))
                                    {{-- title="{{ getTimeAgo($post->updated_at) }}" --}}
                                    <td>{{ $post->cost }}</td>
                                    <td class="text-success">{{ $post->payed }}</td>
                                    <td class="text-danger">{{ $post->cost - $post->payed }}</td>
                                    <td>{{ $post->fees }}</td>
                                    <td
                                        class="{{ countDaysSince($post->lastTransaction) > 30 && ($post->payed != $post->cost || $post->cost == 0) ? 'text-danger' : '' }}">
                                        {{ countDaysSince($post->lastTransaction) }}</td>
                                    {{-- <td>{{ getTimeAgo($post->updated_at) }}</td> --}}
                                    <td class="{{ $post->payed == $post->cost ? 'text-success' : 'text-danger' }} ">
                                        {{ $post->payed == $post->cost ? 'Payed' : 'Not Payed' }}</td>
                                @endif

                                <td style="cursor: pointer;" wire:click="toggleDeal({{ $post->id }})" class="{{ $post->deal ? 'text-success' : 'text-danger' }}">
                                    {{ $post->deal ? 'Yes' : 'No' }}
                                </td>
                                <td style="cursor: pointer;" wire:click="toggleShow({{ $post->id }})" class="{{ $post->appearance ? 'text-success' : 'text-danger' }}">
                                    {{ $post->appearance ? 'Yes' : 'No' }}
                                </td>
                                <td class="{{ $post->deadline < date('Y-m-d') ? 'text-warning ' : '' }}">
                                    {{ $post->deadline }}</td>

                                <td>
                                    <button wire:click="edit({{ $post->id }})"
                                        class="btn btn-outline-primary btn-sm">E</button>




                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $post->id }}">
                                        D
                                    </button>

                                    <div class="modal fade" id="exampleModal{{ $post->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel{{ $post->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel{{ $post->id }}">
                                                        {{ $post->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Are you sure you want to delete this script?<br><br>
                                                        <span class=text-limit" style="--lines:3;">
                                                            {{ $post->title }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger"
                                                        data-bs-dismiss="modal"
                                                        wire:click="delete({{ $post->id }})">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#postModal{{ $post->id }}">
                                        D
                                    </button>

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
                                                            <input type="hidden" name="post_id"
                                                                value="{{ $post->id }}">
                                                            <textarea class="form-control  summernote" name="tasks" id="" cols="30" rows="5">{{ isset($post->tasks) ? $post->tasks : '' }}</textarea>
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
                                    <button type="button" content="{{ $post->ai_prompt }}"
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
