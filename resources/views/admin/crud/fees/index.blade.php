@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains fee content -->
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
                                            <h1 class="card-title fw-bold">@lang('general.fees')</h1>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <a href="{{ route('fees.create') }}">
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
                                                <th>{{__('general.cost')}}</th>
                                                <th>{{__('general.amount')}}</th>
                                                <th>{{__('general.project')}}</th>
                                                <th>{{__('general.note')}}</th>
                                                <th>{{__('general.created_at')}}</th>
                                                <th class="th-controls">@lang('general.controls')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fees as $fee)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ isset($fee->project->cost) ? $fee->project->cost:'None' }}</td>
                                                    <td class="amount {{ $fee->amount > 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ $fee->amount > 0 ? '+' : '' }}{{ $fee->amount }}
                                                    </td>
                                                    
                                                    <td>{{ isset($fee->project->title) ? $fee->project->title:'None' }}</td>
                                                    <td>{{ $fee->note }}</td>
                                                    <td>{{ $fee->created_at }}</td>
                                                    <td>
                                                        @include('admin.components.controls', [
                                                            'route' => 'fees',
                                                            'role' => 'fee',
                                                            'module' => $fee,
                                                        ])
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!-- Summary Row -->
                                        <tfoot>
                                            <tr class="bg-dark text-white">
                                                <td colspan="2" class="text-start fw-bold">Total:</td>
                                                <td id="total-amount"></td> <!-- Cell to display the total amount -->
                                                <td colspan="4"></td>
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
        $(document).ready(function() {
            // Initialize the DataTable and store the instance correctly
            const table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": false,
                "searching": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });

            // Ensure that table is a DataTable instance by debugging it
            console.log("DataTable Instance:", table);

            // Function to calculate the total amount for visible rows
            function calculateTotalAmount() {
                let totalAmount = 0;

                // Check if table instance is valid
                if (table && typeof table.rows === 'function') {
                    // Loop through each visible row in the 'amount' column
                    table.rows({ search: 'applied' }).every(function() {
                        // Get the 'amount' cell for the current row
                        const rowNode = $(this.node());
                        const amountText = rowNode.find('.amount').text().trim();

                        // Debug: Log the captured amount text
                        console.log(`Row Amount Text: "${amountText}"`);

                        // Parse the amount and handle any NaN values
                        let amount = parseFloat(amountText) || 0;

                        // Debug: Log the parsed amount
                        console.log(`Parsed Amount: ${amount}`);

                        totalAmount += amount;
                    });
                } else {
                    console.error("Error: The 'table' instance is not a valid DataTable object.");
                }

                // Display the total amount in the summary row
                console.log(`Total Calculated Amount: ${totalAmount}`);
                $('#total-amount').text(totalAmount.toFixed(2)); // Format with two decimal places
            }

            // Calculate the total amount for visible rows on page load
            calculateTotalAmount();

            // Recalculate total amount on search/filter change
            table.on('search.dt', function() {
                console.log("Search or filter applied. Recalculating total amount...");
                calculateTotalAmount();
            });
        });
    </script>
@endpush





