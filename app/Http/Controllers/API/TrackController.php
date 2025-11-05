<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplainResource;
use App\Models\ClientTrack;
use Exception;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    private $track ;

    public function __construct(Clienttrack $track)
    {
        $this->track = $track ;
    }

public function index() {
    try {
        $tracks = $this->track->latest()->paginate(10);

        $data['tracks'] = $tracks;
        $data['pagination'] = [
            'current_page' => $tracks->currentPage(),
            'last_page' => $tracks->lastPage(),
            'per_page' => $tracks->perPage(),
            'total' => $tracks->total(),
        ];

        return successResponse($data);
    } catch(Exception $e) {
        return failedResponse($e->getMessage());
    }
}

}
