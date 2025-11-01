<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ComplainRequest;
use App\Http\Resources\ComplainResource;
use App\Models\Complain;
use Exception;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    private $complain ;

    public function __construct(Complain $complain)
    {
        $this->complain = $complain ;
    }

    public function index() {
        try {
           $data['complains'] = ComplainResource::collection($this->complain->get());
           return successResponse($data);
        } catch(Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    public function show($id) {
        try{
            $data['complain'] = $this->complain->findorfail($id);
            return successResponse($data);
        } catch(Exception $e) {
            return failedResponse(($e->getmessage()));
        }
    }
    public function store(ComplainRequest $request) {
        try{

            $data['complain'] = Complain::create($request->all());
            return successResponse($data);
        } catch(Exception $e){
            return failedResponse($e->getMessage());
        }
    }
    public function update(ComplainRequest $request , $id) {
        try{
 
            $complain = Complain::find($id);
            $complain->update($request->all());
            return successResponse($complain);
        }catch(Exception $e){
            return failedResponse($e->getMessage());
        }
    }
    public function delete($id){
        try{
            $complain = Complain::find($id);
            $complain->delete();
            return successResponse($complain);
        }catch(Exception $e){
            return failedResponse($e->getMessage());
        }
    }
}
