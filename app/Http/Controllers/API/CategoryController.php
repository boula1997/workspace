<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

public function index()
{
    try {
        $query = $this->category->orderBy('title', 'asc'); // alphabetically A → Z
        
        // Filter by type if provided in query
        if (request()->has('type') && request()->query('type')) {
            $query->where('type', request()->query('type'));
        }
        
        // Everyone but a super admin sees only the modules ticked on their admin page (the
        // "Index modules" section); this replaces the fixed fees + projects list
        if (!boula()) {
            $admin = auth('admin-api')->user() ?? auth('api')->user();
            $allowed = $admin instanceof \App\Models\Admin ? $admin->indexModules()->pluck('categories.id') : collect();
            $query->whereIn('id', $allowed);
        }
        
        $data['categories'] = CategoryResource::collection(
            $query->get()
        );
        
        return successResponse($data);
    } catch (Exception $e) {
        return failedResponse($e->getMessage());
    }
}
    public function show($id)
    {
        try {
            $data['category'] = new CategoryResource($this->category->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
}
