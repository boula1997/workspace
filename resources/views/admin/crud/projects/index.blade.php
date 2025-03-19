@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains project content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="container p-3">
            <section class="content pt-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <select id="projectFilter" class="form-control" multiple>
                                    @foreach ($projects as $project)
                                        @if (rest($project) > 0)
                                            <option value="{{ $project->title }}">{{ $project->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-start">
                                            <h1 class="card-title fw-bold">@lang('general.projects')</h1>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <a href="{{ route('projects.create') }}">
                                                <button class="btn btn-outline-primary px-5">
                                                    <i class="fa fa-plus fa-sm px-2" aria-hidden="true"></i>
                                                    @lang('general.add')
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('general.title') }}</th>

                                                <th>{{ __('general.cost') }}</th>

                                                <th>{{ __('general.payed') }}</th>

                                                <th>{{ __('general.debit') }}</th>

                                                <th>{{ __('general.isYousab') }}</th>

                                                <th>{{ __('general.status') }}</th>

                                                <th>{{ __('general.appearance') }}</th>

                                                <th>{{ __('general.deal') }}</th>

                                                <th>{{ __('general.deadline') }}</th>

                                                <th>{{ __('general.lastTransaction') }}</th>

                                                <th>{{ __('general.fees') }}</th>
                                                <th class="th-controls">@lang('general.controls')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $project->title }}</td>
                                        
                                                    <td class="cost">{{ $project->cost }}</td>
                                        
                                                    <td>{{ $project->payed }}</td>
                                        
                                                    <td class="rest">{{ rest($project) }}</td>
                                        
                                                    <td>{{ $project->isYousab ? __('general.yes') : __('general.no') }}</td>
                                        
                                                    <td>{{ $project->status ? __('general.yes') : __('general.no') }}</td>
                                        
                                                    <td>{{ $project->appearance ? __('general.yes') : __('general.no') }}</td>
                                        
                                                    <td>{{ $project->deal ? __('general.yes') : __('general.no') }}</td>
                                        
                                                    <td>{{ $project->deadline }}</td>
                                        
                                                    <td>{{ $project->lastTransaction }}</td>
                                        
                                                    <td>{{ $project->fees }}</td>
                                        
                                                    <td>
                                                        @include('admin.components.controls', [
                                                            'route' => 'projects',
                                                            'role' => 'project',
                                                            'module' => $project,
                                                        ])
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        

                                    </table>

                                    <!-- Separate tfoot for better responsiveness -->
                                    <div class="table-footer-summary">
                                        <table class="table">
                                            <tr>
                                                <td colspan="2" class="text-right fw-bold">Total Cost:</td>
                                                <td id="total-cost"></td>
                                                <td id="total-rest"></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('scripts')
    <script>
        $(function() {
            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "stateSave": true,
                "search": {
                    "smart": true
                }
            });

            // table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#projectFilter').on('change', function() {
                var selectedTitles = $(this).val();
                table.columns(1).search(selectedTitles ? selectedTitles.join('|') : '', true, false).draw();
            });

            function calculateTotals() {
                let totalCost = 0,
                    totalRest = 0;

                table.rows({
                    search: 'applied'
                }).every(function() {
                    let rowNode = $(this.node());

                    let cost = parseFloat(rowNode.find('.cost').text().replace(/[^0-9.-]+/g, "")) || 0;
                    let rest = parseFloat(rowNode.find('.rest').text().replace(/[^0-9.-]+/g, "")) || 0;

                    totalCost += cost;
                    totalRest += rest;
                });

                $('#total-cost').text(totalCost.toFixed(2));
                $('#total-rest').text(totalRest.toFixed(2));
            }

            calculateTotals();
            table.on('search.dt draw.dt', calculateTotals);
        });
    </script>
@endpush
