<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowupResource;
use App\Models\Followup;
use Exception;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    private $followup;
    public function __construct(Followup $followup)
    {
        $this->followup = $followup;
    }

    public function index()
    {
        try {
            $data['followups'] = FollowupResource::collection($this->followup->get());
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data['followup'] = new FollowupResource($this->followup->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
}
