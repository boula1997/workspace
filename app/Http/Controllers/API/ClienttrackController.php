<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Clienttrack;
use Exception;
use Illuminate\Http\Request;

class ClienttrackController extends Controller
{
    private $clienttrack;
    public function __construct(Clienttrack $clienttrack)
    {
        $this->clienttrack = $clienttrack;
    }

    public function index()
    {
        try {
            $data['clienttracks'] = $this->clienttrack->get();
            return successResponse($data,trans('general.sent_successfully'));
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data['faclienttrackq'] = new FaqResource($this->clienttrack->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
    public function clienttrack($project_id,$action)
    {
        try {
            $src = request()->query('src'); 
            $data=$this->clienttrack->create([
                "project_id"=>$project_id,
                "action"=>$action,
                "src"=>$src,
            ]);
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
}
