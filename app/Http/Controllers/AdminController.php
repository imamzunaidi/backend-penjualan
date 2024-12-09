<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
      {
        $admin = User::where('role', 'admin')->get();
        return response()->json([
            'status' => $admin->isEmpty() ? 'failed' : 'success',
            'message' => $admin->isEmpty() ? 'No admin found' : 'admin retrieved successfully',
            'data' => $admin
        ]);
      }
  
      public function detail($id)
      {
        $admin = User::findOrFail($id);

        if (!$admin) {
            return response()->json([
                'status' => 'failed',
                'message' => 'admin not found'
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'admin retrieved successfully',
            'data' => $admin
        ]);
      }
  
      public function insert(Request $request)
      {
         
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        //     'role' => 'required|in:admin,pelanggan',  // Validasi role
        // ]);
        try {

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,  // Menetapkan role
            ];

            $admin = User::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'admin created successfully',
                'data' => $admin
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'admin creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
  
      public function update(Request $request, $id)
      {

        $admin = User::findOrFail($id);
  
        if (!$admin) {
            return response()->json([
                'status' => 'failed',
                'message' => 'admin not found'
            ], 404);
        }

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                // 'role' => $request->role,  // Menetapkan role
            ];
            $admin->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'admin updated successfully',
                'data' => $admin
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'admin update failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
  
      public function delete($id)
      {
        $admin = User::find($id);

        if (!$admin) {
            return response()->json([
                'status' => 'failed',
                'message' => 'admin not found'
            ], 404);
        }
    
        try {
            $admin->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'admin deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'admin deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
}
