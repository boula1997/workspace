<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Clienttrack;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;

class ClienttrackController extends Controller
{
    public const PROFILE_PROJECT = 'Profile';

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

    // The profile site has its own personal project (created by migration), found by title
    // so the site does not need to know a database id.
    public function profileTrack($action)
    {
        $projectId = Project::withoutGlobalScopes()
            ->where('title', self::PROFILE_PROJECT)
            ->where('isPersonal', 1)
            ->value('id');

        if (!$projectId) {
            return failedResponse('Profile project not found');
        }

        return $this->clienttrack($projectId, mb_substr($action, 0, 191));
    }
}
