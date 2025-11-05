<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplainResource;
use App\Models\Clienttrack;
use Exception;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    private $track ;

    public function __construct(Clienttrack $track)
    {
        $this->track = $track ;
    }

public function index($id, Request $request) {
    try {
        $query = $this->track->where("project_id", $id);

        if ($request->filled("action")) {
            $query->where("action", "like", "%" . $request->action . "%");
        }

        if ($request->filled("from")) {
            $query->whereDate("created_at", ">=", $request->from);
        }

        if ($request->filled("to")) {
            $query->whereDate("created_at", "<=", $request->to);
        }

        $tracks = $query->latest()->paginate(10);

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
