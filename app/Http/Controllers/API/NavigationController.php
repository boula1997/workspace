<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NavigationResource;
use App\Models\Navigation;
use Exception;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    private $navigation;
    public function __construct(Navigation $navigation)
    {
        $this->navigation = $navigation;
    }

    public function index()
    {
        try {
            $data['navigations'] = NavigationResource::collection($this->navigation->get());
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data['navigation'] = new NavigationResource($this->navigation->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
}
