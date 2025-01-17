<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountantResource;
use App\Models\Accountant;
use Exception;
use Illuminate\Http\Request;

class AccountantController extends Controller
{
    private $accountant;
    public function __construct(Accountant $accountant)
    {
        $this->accountant = $accountant;
    }

    public function index()
    {
        try {
            $data['accountants'] = AccountantResource::collection($this->accountant->get());
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data['accountant'] = new AccountantResource($this->accountant->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
}
