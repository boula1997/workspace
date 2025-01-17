<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;
use App\Models\History;
use Exception;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    private $history;
    public function __construct(History $history)
    {
        $this->history = $history;
    }

    public function index()
    {
        try {
            $data['historys'] = HistoryResource::collection($this->history->get());
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data['history'] = new HistoryResource($this->history->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
}
