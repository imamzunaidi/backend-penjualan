<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
      $brands = Brand::all();

      return response()->json([
          'status' => $brands->isEmpty() ? 'failed' : 'success',
          'message' => $brands->isEmpty() ? 'No brands found' : 'brands retrieved successfully',
          'data' => $brands
      ]);
    }

    // Menampilkan kategori berdasarkan ID
    public function detail($id)
    {
      $brand = Brand::findOrFail($id);
      if (!$brand) {
          return response()->json([
              'status' => 'failed',
              'message' => 'brand not found'
          ], 404);
      }
  
      return response()->json([
          'status' => 'success',
          'message' => 'brand retrieved successfully',
          'data' => $brand
      ]);
    }

    public function insert(Request $request)
    {
      $request->validate([
          'name_brand' => 'required|string|max:255',
      ]);

      try {
          $brand = Brand::create([
            'name_brand' => $request->name_brand,
          ]);
          return response()->json([
              'status' => 'success',
              'message' => 'brand created successfully',
              'data' => $brand
          ], 201);
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'brand creation failed',
              'error' => $e->getMessage()
          ], 500);
      }
    }

    // Mengupdate kategori
    public function update(Request $request, $id)
    {

      $brand = Brand::findOrFail($id);

      if (!$brand) {
          return response()->json([
              'status' => 'failed',
              'message' => 'brand not found'
          ], 404);
      }

      try {
          $brand->update([
            'name_brand' => $request->name_brand,
          ]);
          return response()->json([
              'status' => 'success',
              'message' => 'brand updated successfully',
              'data' => $brand
          ]);
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'brand update failed',
              'error' => $e->getMessage()
          ], 500);
      }
    }

    // Menghapus kategori
    public function delete($id)
    {
      $brand = Brand::find($id);

      if (!$brand) {
          return response()->json([
              'status' => 'failed',
              'message' => 'brand not found'
          ], 404);
      }
  
      try {
          $brand->delete();
          return response()->json([
              'status' => 'success',
              'message' => 'brand deleted successfully'
          ]);
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'brand deletion failed',
              'error' => $e->getMessage()
          ], 500);
      }
    }
}
