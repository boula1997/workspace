<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.1-dist/js/bootstrap.min.js') }}">
    <title>Query Results</title>
    <style>
        /* General Dark Theme Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #121212; /* Dark background */
            color: #ffffff; /* Light text */
        }
        
        h1, h2, h3, h4 {
            color: #ffffff; /* Headings with white text */
        }

        p {
            color: #cccccc; /* Subdued text for paragraphs */
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
            background-color: #1e1e1e; /* Table background */
            color: #ffffff; /* Table text color */
        }
        
        table th, table td {
            border: 1px solid #444444; /* Subtle table borders */
            padding: 8px;
        }
        
        table th {
            background-color: #333333; /* Header row background */
            text-align: left;
            color:#ffffff;
        }

        .no-data {
            color: #bbbbbb; /* Subtle color for "no data" messages */
            font-style: italic;
        }

        /* Row Highlight Styles */
        .table-success {
            background-color: #66dc6c; /* Green shade for success */
            color: #000000;
        }

        .table-warning {
            background-color: #ff9800; /* Orange shade for warning */
            color: #000000;
        }

        a {
            color: #64b5f6; /* Light blue links */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <input type="datetime-local" class="bg-dark text-white form-control" id="minutes"  class="form-control w-25" name="queyDate">
    

    <h1>Query Results</h1>

    <h2>Tables with Recent Updates on 'Created At'</h2>
    @if (!empty($latestRows))
        @foreach ($latestRows as $tableName => $rows)
            @if (!empty($rows) && array_key_exists('created_at', $rows[0]))  <!-- Check if 'created_at' exists and rows are not empty -->
                <h3>Latest Rows from Table: {{ $tableName }}</h3>
                <table class="table-success">
                    <thead>
                        <tr>
                            @foreach (array_keys((array)$rows[0]) as $column)
                                <th>{{ $column }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                @if ($row['created_at'] == $row['updated_at']) <!-- Only show rows where 'created_at' is not equal to 'updated_at' -->
                                <tr>
                                    @foreach ($row as $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @else
        <p class="no-data">No tables found with recent updates on 'created_at'.</p>
    @endif

    <h2>Tables with Recent Updates on 'Updated At'</h2>
    @if (!empty($latestRows))
        @foreach ($latestRows as $tableName => $rows)
            @if (!empty($rows) && array_key_exists('updated_at', $rows[0]))  <!-- Check if 'updated_at' exists and rows are not empty -->
                <h3>Latest Rows from Table: {{ $tableName }}</h3>
                <table class="table-warning">
                    <thead class="text-white">
                        <tr>
                            @foreach (array_keys((array)$rows[0]) as $column)
                                <th>{{ $column }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                @if ($row['updated_at'] >$row['created_at']) <!-- Only show rows where 'created_at' is not equal to 'updated_at' -->
                                <tr>
                                    @foreach ($row as $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @else
        <p class="no-data">No tables found with recent updates on 'updated_at'.</p>
    @endif

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Retrieve and set the previously selected interval from localStorage
        $('#minutes').val(localStorage.getItem('minutes'));

        // Handle input change
        $('#minutes').on('change', function () {
            let interval = $(this).val();
            localStorage.setItem('minutes', interval);

            if (interval) {
                const baseURL = `{{ url('/run-query') }}`;
                const queryParams = `?dbname={{ $dbname }}&username={{ $username }}&password={{ $password }}&interval=${interval}`;
                const fullURL = baseURL + queryParams;

                // Open the URL with the new interval
                window.open(fullURL, '_blank');
            } else {
                alert('Please select a valid interval.');
            }
        });
    });
</script>

</html>
