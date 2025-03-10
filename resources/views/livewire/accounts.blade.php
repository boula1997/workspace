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
                            <th> <button type="button" content="{{ $combinedCodeLinks }}"
                                    class="w-100 btn btn-outline-danger btn-sm browse">
                                    Prepare All
                                </button></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ Str::limit($account->title, 15) }}</td>
                                @if (!request()->routeIs('notes'))
                                    {{-- title="{{ getTimeAgo($account->updated_at) }}" --}}
                                    <td>{{ $account->cost }}</td>
                                    <td class="text-success">{{ $account->payed }}</td>
                                    <td class="text-danger">{{ $account->cost - $account->payed }}</td>
                                    <td>{{ $account->fees }}</td>
                                    <td
                                        class="{{ countDaysSince($account->lastTransaction) > 30 && ($account->payed != $account->cost || $account->cost == 0) ? 'text-danger' : '' }}">
                                        {{ countDaysSince($account->lastTransaction) }}</td>
                                    {{-- <td>{{ getTimeAgo($account->updated_at) }}</td> --}}
                                    <td class="{{ $account->payed == $account->cost ? 'text-success' : 'text-danger' }} ">
                                        {{ $account->payed == $account->cost ? 'Payed' : 'Not Payed' }}</td>
                                @endif

                                <td style="cursor: pointer;" wire:click="toggleDeal({{ $account->id }})" class="{{ $account->deal ? 'text-success' : 'text-danger' }}">
                                    {{ $account->deal ? 'Yes' : 'No' }}
                                </td>
                                <td style="cursor: pointer;" wire:click="toggleShow({{ $account->id }})" class="{{ $account->appearance ? 'text-success' : 'text-danger' }}">
                                    {{ $account->appearance ? 'Yes' : 'No' }}
                                </td>
                                <td class="{{ $account->deadline < date('Y-m-d') ? 'text-warning ' : '' }}">
                                    {{ $account->deadline }}</td>

                                <td>
                                    <button wire:click="edit({{ $account->id }})"
                                        class="btn btn-outline-primary btn-sm">E</button>




                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $account->id }}">
                                        D
                                    </button>

                                    <div class="modal fade" id="exampleModal{{ $account->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel{{ $account->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel{{ $account->id }}">
                                                        {{ $account->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Are you sure you want to delete this script?<br><br>
                                                        <span class=text-limit" style="--lines:3;">
                                                            {{ $account->title }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger"
                                                        data-bs-dismiss="modal"
                                                        wire:click="delete({{ $account->id }})">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#accountModal{{ $account->id }}">
                                        D
                                    </button>

                                    <div class="modal fade" id="accountModal{{ $account->id }}" tabindex="-1"
                                        aria-labelledby="accountModalLabel{{ $account->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="accountModalLabel{{ $account->id }}">
                                                        {{ $account->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form id="accountForm" method="account">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div>
                                                            <input type="hidden" name="account_id"
                                                                value="{{ $account->id }}">
                                                            <textarea class="form-control  summernote" name="tasks" id="" cols="30" rows="5">{{ isset($account->tasks) ? $account->tasks : '' }}</textarea>
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
                                    <button type="button" content="{{ $account->codeLinks }}"
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
