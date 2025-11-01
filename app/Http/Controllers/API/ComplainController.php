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
        // Adjust the number per page as needed, e.g., 10
        $complains = $this->complain->paginate(10);

        // Wrap each complain in a resource
        $data['complains'] = ComplainResource::collection($complains);

        // Include pagination metadata
        $data['pagination'] = [
            'current_page' => $complains->currentPage(),
            'last_page' => $complains->lastPage(),
            'per_page' => $complains->perPage(),
            'total' => $complains->total(),
        ];

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
    public function destroy($id){
        try{
            $complain = Complain::find($id);
            $complain->delete();
            return successResponse($complain);
        }catch(Exception $e){
            return failedResponse($e->getMessage());
        }
    }
}
