@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains project content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="container p-3">
            <section class="content pt-2">
                <div class="container-fluid">
                    <div class="row">
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
                                                <th>{{__('general.title')}}</th>
                                                <th>{{__('general.cost')}}</th>
                                                <th>{{__('general.rest')}}</th>
                                                <th>{{__('general.status')}}</th>
                                                <th>@lang('general.controls')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $project->title }}</td>
                                                    <td class="cost">{{ $project->cost }}</td>
                                                    <td class="rest">{{ rest($project) }}</td> <!-- Add class 'rest' to this cell -->
                                                    <td>{{ $project->status ? __('general.yes') : __('general.no') }}</td>
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
                                        <!-- Summary Row -->
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-right fw-bold">Total Cost:</td>
                                                <td id="total-cost"></td> <!-- Cell to display the total cost -->
                                                <td id="total-rest"></td> <!-- Cell to display the total rest -->
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
        const tableStateKey = "coursesTableState";

        var table = $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "stateSave": true,
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem(tableStateKey);
                return savedState ? JSON.parse(savedState) : null;
            },
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem(tableStateKey, JSON.stringify(data));
            }
        });

        // Append DataTable buttons to container
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Multi-term search functionality
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const searchInput = $('#example1_filter input').val();
            if (!searchInput) return true;  // If no input, show all rows

            const terms = searchInput.split(/\s+/); // Split by space (or add commas if needed)
            for (let term of terms) {
                // If a term is not found in the row data, exclude this row
                if (!data.join(' ').toLowerCase().includes(term.toLowerCase())) {
                    return false;
                }
            }
            return true;
        });

        // Trigger recalculating totals after multi-term search
        $('#example1_filter input').on('keyup', function() {
            table.draw();
            calculateTotals(); // Recalculate totals after search
        });

        function calculateTotals() {
            let totalCost = 0;
            let totalRest = 0;

            table.rows({ search: 'applied' }).every(function() {
                const rowNode = $(this.node());

                let costText = rowNode.find('.cost').text().trim();
                let cost = parseFloat(costText.replace(/[^0-9.-]+/g, "")) || 0;
                totalCost += cost;

                let restText = rowNode.find('.rest').text().trim();
                let rest = parseFloat(restText.replace(/[^0-9.-]+/g, "")) || 0;
                totalRest += rest;
            });

            $('#total-cost').text(totalCost.toFixed(2));
            $('#total-rest').text(totalRest.toFixed(2));
        }

        // Calculate totals initially
        calculateTotals();

        // Recalculate totals whenever search or column visibility changes
        table.on('search.dt column-visibility.dt', function() {
            calculateTotals();
        });
    });
</script>

@endpush

