<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
      public function index()
      {
        $categories = Category::all();
        return response()->json([
            'status' => $categories->isEmpty() ? 'failed' : 'success',
            'message' => $categories->isEmpty() ? 'No categories found' : 'Categories retrieved successfully',
            'data' => $categories
        ]);
      }
  
      public function detail($id)
      {
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => $category
        ]);
      }
  
      public function insert(Request $request)
      {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        
        try {
            $category = Category::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
  
      public function update(Request $request, $id)
      {

        $category = Category::findOrFail($id);
  
        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ], 404);
        }

        try {
            $category->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category update failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
  
      public function delete($id)
      {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ], 404);
        }
    
        try {
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
}
