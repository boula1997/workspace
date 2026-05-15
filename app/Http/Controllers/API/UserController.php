<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use App\Models\File as ModelsFile; 
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $user;
    function __construct(User $user)
    {
        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->user = $user;
    }

public function index(Request $request)
{
    try {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        
        // Start building the query
        $query = User::query();
        
        // Filter by search term (name, email)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('isActive', $status === 'active' ? 1 : 0);
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }
        
        // Filter by date range
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $query->whereBetween('created_at', [
                $request->input('startDate') . ' 00:00:00',
                $request->input('endDate') . ' 23:59:59'
            ]);
        }
        
        // Apply ordering
        $sortBy = $request->input('sortBy', 'id');
        $sortOrder = $request->input('sortOrder', 'DESC');
        $query->orderBy($sortBy, $sortOrder);
        
        // Paginate results
        $users = $query->paginate($perPage, ['*'], 'page', $page);
        
        return successResponse($users, 'Users fetched successfully');
        
    } catch (Exception $e) {
        \Log::error('Users fetch error: ' . $e->getMessage());
        return failedResponse(['error' => $e->getMessage()], 'Failed to fetch users', 500);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->uploadFile();
            return successResponse([], __('general.created'));
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to create user', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return successResponse($user, 'User fetched successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $input = $request->except('image','profile_avatar_remove');
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }
            $user = User::find($id);
            $user->update($input);
            $user->updateFile();
            return successResponse($user, 'User updated successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to process request', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            $user->deleteFile();
            return successResponse([], 'User deleted successfully');
        } catch (Exception $e) {
            return response()->json(['error' => __('general.something_wrong')],500);
        }
    }
}
