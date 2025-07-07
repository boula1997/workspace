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
                    @include('livewire.updateCredential')
                @else
                    @include('livewire.createCredential')
                @endif
            </div>
        @endif
        <div class="{{ request()->routeIs('notes') ? 'd-flex justify-content-center row' : 'col-md-9' }} overflow-auto">

            <div class="{{ request()->routeIs('notes') ? 'col-md-8 d-flex-justify-content-center' : '' }}">
                <button onclick="exportTableToExcel('tableID', 'accounts')">Export to Excel</button>
                <table id="tableID" class="table  table-hover table-dark table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th width="120px" class="text-white text-decoration-none" style="cursor:pointer;" wire:click.prevent="sortBy('title')">Name</th>
                            <th class="text-white text-decoration-none" style="cursor:pointer;" >Host</th>
                            <th class="text-white text-decoration-none" style="cursor:pointer;" >Password</th>
                            <th class="text-white text-decoration-none" style="cursor:pointer;" >Actions</th>

                        </tr>
                    </thead>
                    <tbody style="height:auto !important;">
                        @foreach ($credentials as $credential)
                            <tr style="height:auto !important;" class="mb-5 pb-5">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $credential->db_name }}
                                </td>
                                <td>
                                    {{ $credential->db_username }}
                                </td>
                                <td>
                                    {{ $credential->db_password }}
                                </td>
                                <td>
                                    <button wire:click="edit({{ $credential->id }})"
                                        class="btn btn-outline-primary btn-sm">E</button>




                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $credential->id }}">
                                        D
                                    </button>

                                    <div class="modal fade" id="exampleModal{{ $credential->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel{{ $credential->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel{{ $credential->id }}">
                                                        {{ $credential->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Are you sure you want to delete this script?<br><br>
                                                        <span class=text-limit" style="--lines:3;">
                                                            {{ $credential->title }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger"
                                                        data-bs-dismiss="modal"
                                                        wire:click="delete({{ $credential->id }})">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#credentialModal{{ $credential->id }}">
                                        D
                                    </button>

                                    <div class="modal fade" id="credentialModal{{ $credential->id }}" tabindex="-1"
                                        aria-labelledby="credentialModalLabel{{ $credential->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="credentialModalLabel{{ $credential->id }}">
                                                        {{ $credential->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form id="credentialForm" method="credential">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div>
                                                            <input type="hidden" name="credential_id"
                                                                value="{{ $credential->id }}">
                                                            <textarea class="form-control  summernote" name="tasks" id="" cols="30" rows="5">{{ isset($credential->tasks) ? $credential->tasks : '' }}</textarea>
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

                                    <a href="https://oilminingshah.com/workspace/public/run-query?dbname={{ $credential->db_name }}&username={{ $credential->db_username }}&password={{ $credential->db_password }}&interval={{now()->toDateTimeString()}}" target="__blank">
                                        Test Screen
                                    </a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>


