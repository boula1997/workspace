<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Models\File as ModelsFile;
use Exception;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Display a listing of all admins with pagination
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $page = $request->input('page', 1);
            
            $admins = Admin::orderBy('id', 'DESC')
                ->paginate($perPage, ['*'], 'page', $page);
            
            return successResponse([
                'items' => $admins->items(),
                'pagination' => [
                    'total' => $admins->total(),
                    'per_page' => $admins->perPage(),
                    'current_page' => $admins->currentPage(),
                    'last_page' => $admins->lastPage(),
                    'from' => $admins->firstItem(),
                    'to' => $admins->lastItem(),
                ]
            ], 'Admins fetched successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to fetch admins', 500);
        }
    }

    /**
     * Get all available roles for creating/editing admins
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles(Request $request)
    {
        try {
            $roles = Role::pluck('name', 'id');
            
            return successResponse($roles, 'Roles fetched successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to fetch roles', 500);
        }
    }

    /**
     * Store a newly created admin in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminRequest $request)
    {
        try {
            // dectatorBoula(); // Remove or implement as needed
            $input = $request->except('image', 'profile_avatar_remove');
            $input["type"] = $request->input('roles');
            $input['password'] = Hash::make($input['password']);
            
            $admin = Admin::create($input);
            $admin->assignRole($request->input('roles'));
            $admin->uploadFile();
            
            return successResponse($admin, 'Admin created successfully', 201);
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to create admin', 500);
        }
    }

    /**
     * Display the specified admin
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $admin = Admin::with('roles')->find($id);
            
            if (!$admin) {
                return failedResponse([], 'Admin not found', 404);
            }
            
            return successResponse($admin, 'Admin fetched successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to fetch admin', 500);
        }
    }

    /**
     * Get admin with roles for editing
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * Update the specified admin in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminRequest $request, $id)
    {
        try {
            // dectatorBoula(); // Remove or implement as needed
            
            $admin = Admin::find($id);
            
            if (!$admin) {
                return failedResponse([], 'Admin not found', 404);
            }
            
            $input = $request->except('image', 'profile_avatar_remove');
            $input["type"] = $request->input('roles');
            
            // Only hash password if provided
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, ['password']);
            }
            
            $admin->update($input);
            
            // Update roles
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $admin->assignRole($request->input('roles'));
            
            // Handle file uploads
            $admin->updateFile();
            
            return successResponse($admin, 'Admin updated successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to update admin', 500);
        }
    }

    /**
     * Remove the specified admin from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // dectatorBoula(); // Remove or implement as needed
            
            $admin = Admin::find($id);
            
            if (!$admin) {
                return failedResponse([], 'Admin not found', 404);
            }
            
            // Delete associated files
            $admin->deleteFile();
            if ($admin->image) {
                File::delete($admin->image);
            }
            
            // Delete admin
            $admin->delete();
            
            return successResponse([], 'Admin deleted successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to delete admin', 500);
        }
    }

    /**
     * Bulk delete admins
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return failedResponse([], 'No IDs provided', 400);
            }
            
            $admins = Admin::whereIn('id', $ids)->get();
            
            foreach ($admins as $admin) {
                $admin->deleteFile();
                if ($admin->image) {
                    File::delete($admin->image);
                }
                $admin->delete();
            }
            
            return successResponse([], 'Admins deleted successfully');
        } catch (Exception $e) {
            return failedResponse(['error' => $e->getMessage()], 'Failed to delete admins', 500);
        }
    }
}