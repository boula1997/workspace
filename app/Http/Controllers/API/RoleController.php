<?php
    
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    try {
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);
        
        // Start building the query
        $query = Role::query();
        
        // Filter by search term (role name)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }
        
        // Filter by guard name
        if ($request->filled('guard')) {
            $query->where('guard_name', $request->input('guard'));
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('isActive', $status === 'active' ? 1 : 0);
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
        
        // Map sortBy to actual column names if needed
        $sortColumn = $sortBy;
        if ($sortBy === 'guard_name') {
            $sortColumn = 'guard_name';
        } elseif ($sortBy === 'isActive') {
            $sortColumn = 'isActive';
        }
        
        $query->orderBy($sortColumn, $sortOrder);
        
        // Paginate results
        $roles = $query->paginate($perPage, ['*'], 'page', $page);
        
        return successResponse($roles, 'Roles fetched successfully');
        
    } catch (Exception $e) {
        \Log::error('Roles fetch error: ' . $e->getMessage());
        return failedResponse(['error' => $e->getMessage()], 'Failed to fetch roles', 500);
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'admin']);
        $role->syncPermissions($request->input('permission'));
    
        return successResponse([], 'Operation successful');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return successResponse($rolePermissions, 'Role permissions fetched successfully');
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->guard_name = 'admin';
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return successResponse([], 'Operation successful');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return successResponse([], 'Role deleted successfully');
    }


        public function all_permissions()
    {
        try {
            $data = Permission::orderBy('id', 'DESC')->get();
            return successResponse($data, 'Permissions fetched successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to process request', 500);
        }
    }


    public function all_roles()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return response()->json([
            'success' => true,
            'message' => 'All roles fetched successfully',
            'data' => $roles
        ]);
    }
}