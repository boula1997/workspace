<div>
    <style>
        .note-toolbar {
            z-index: 9999; /* Set a high z-index value */
        }
        .overflow-auto {
            height: calc(100vh - 200px); /* Adjust this value as per your layout */
            overflow-y: auto; /* Ensure vertical scrolling */
        }
        .table-container {
            height: 100%;
            overflow-y: auto; /* Ensure vertical scrolling */
        }
        .table {
            width: 100%;
            table-layout: fixed;
        }
        .table th, .table td {
            word-wrap: break-word;
        }
    </style>
    <div class="container-fluid">
        @if ($updateMode)
            @include('livewire.updateServer')
        @else
            @include('livewire.createServer')
        @endif
    </div>
    <div class="row">
        <div class="me-2 d-flex">                
            <button type="button" id="toggleColumns" class="btn btn-primary mx-2 my-2">Hide</button>
            <button type="button" id="readAllTitles" class="btn btn-success  mx-2 my-2">Read</button>
            <button type="button" id="deleteYellowText" class="btn btn-danger  mx-2 my-2" wire:click="deleteYellowTitles">Delete Yellow</button>
            <button type="button" id="necessaryYellowText" class="btn btn-primary mx-2" wire:click="necessaryYellowTitles">Necessary Yellow Titles</button>
            <button type="button" id="automationYellowText" class="btn btn-primary mx-2" wire:click="automationYellowTitles">Automation Yellow Titles</button>
            <button type="button" id="easyYellowText" class="btn btn-primary mx-2" wire:click="easyYellowTitles">Easy Yellow Titles</button>
            <button id="stopReadingButton">Stop Reading for 60 Minutes</button>


        </div>
        <div class="col-md-12 overflow-auto">
            <div class="table-container">
                <table class="table table-hover table-dark table-striped">
                    <thead>
                        <tr>
                            <th width="40px">No.</th>
                            <th width="600px">
                                <a href="#" class="text-white text-decoration-none" wire:click.prevent="sortBy('title')">Title</a>
                            </th>
                            <th class="toggle-column">
                                <a href="#" class="text-white text-decoration-none" wire:click.prevent="sortBy('project')">Project</a>
                            </th>
                            <th class="toggle-column">
                                <a href="#" class="text-white text-decoration-none">Employee</a>
                            </th>
                            <th class="toggle-column">
                                <a href="#" class="text-white text-decoration-none" wire:click.prevent="sortBy('necessary')">Necessary</a>
                            </th>
                            <th class="toggle-column">
                                <a href="#" class="text-white text-decoration-none" wire:click.prevent="sortBy('automation')">Automation</a>
                            </th>
                            <th class="toggle-column">
                                <a href="#" class="text-white text-decoration-none" wire:click.prevent="sortBy('easy')">Easy</a>
                            </th>
                            <th class="toggle-column" width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servers as $server)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="cursor: pointer;" class="{{ $server->committed ? 'text-success fw-bold' : '' }} {{ $server->color ? 'text-warning fw-bold' : '' }}" data-title="{{ $server->title }}" wire:click="toggleColor({{ $server->id }})">
                                    {{ $server->title }}
                                </td>
                                <td class="toggle-column">{{ $server->project }}</td>
                                <td class="toggle-column">{{ $server->employee }}</td>
                                <td class="toggle-column {{ $server->necessary ? 'text-success' : 'text-danger' }}" style="cursor: pointer;" wire:click="toggleNecessary({{ $server->id }})">
                                    {{ $server->necessary ? 'Yes' : 'No' }}
                                </td>
                                <td class="toggle-column {{ $server->automation ? 'text-success' : 'text-danger' }}" style="cursor: pointer;" wire:click="toggleAutomation({{ $server->id }})">
                                    {{ $server->automation ? 'Yes' : 'No' }}
                                </td>
                                <td class="toggle-column {{ $server->easy ? 'text-success' : 'text-danger' }}" style="cursor: pointer;" wire:click="toggleEasy({{ $server->id }})">
                                    {{ $server->easy ? 'Yes' : 'No' }}
                                </td>
                                <td class="toggle-column">
                                    <button wire:click="edit({{ $server->id }})" class="btn btn-outline-primary btn-sm">Edit</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $server->id }}">
                                        Delete
                                    </button>
                                    <div class="modal fade" id="exampleModal{{ $server->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $server->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel{{ $server->id }}">{{ $server->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this script?<br><br>
                                                        <span class="text-warning text-limit" style="--lines:3;">{{ $server->title }}</span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="delete({{ $server->id }})">Delete</button>
                                                </div>
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
</div>


