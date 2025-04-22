<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        iframe {
            width: 100%;
            height: 500px;
            border: none;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Video List</h2>
    @if(isset($videos) && count($videos))
        <div class="row gy-4">
            @foreach($videos as $video)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card bg-dark text-white">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast('4KPzCKNygFY', 'v=') }}"
                                    allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Video {{ $loop->index + 1 }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No videos found.</p>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
