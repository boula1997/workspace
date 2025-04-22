<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Tabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .nav-tabs .nav-link.active {
            background-color: #1f1f1f;
            border-color: #333 #333 #1f1f1f;
        }
        .nav-tabs .nav-link {
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
    <h2 class="mb-4">Video Tabs</h2>
    @if(isset($videos) && count($videos))
        <ul class="nav nav-tabs" id="videoTabs" role="tablist">
            @foreach($videos as $index => $video)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                            id="tab-{{ $index }}"
                            data-bs-toggle="tab"
                            data-bs-target="#video-{{ $index }}"
                            type="button"
                            role="tab">
                        Video {{ $index + 1 }}
                    </button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content mt-4" id="videoTabsContent">
            @foreach($videos as $index => $video)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                     id="video-{{ $index }}"
                     role="tabpanel">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($video, 'v=') }}"
                                allowfullscreen></iframe>
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
