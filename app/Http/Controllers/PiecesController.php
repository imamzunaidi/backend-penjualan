<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pieces;


class PiecesController extends Controller
{
    public function index()
    {
      $pieces = Pieces::all();

      return response()->json([
          'status' => $pieces->isEmpty() ? 'failed' : 'success',
          'message' => $pieces->isEmpty() ? 'No pieces found' : 'pieces retrieved successfully',
          'data' => $pieces
      ]);
    }
    public function detail($id)
    {
      $pieces = Pieces::findOrFail($id);
      if (!$pieces) {
          return response()->json([
              'status' => 'failed',
              'message' => 'pieces not found'
          ], 404);
      }
  
      return response()->json([
          'status' => 'success',
          'message' => 'pieces retrieved successfully',
          'data' => $pieces
      ]);
    }

    public function insert(Request $request)
    {
      $request->validate([
          'pieces' => 'required|string|max:255',
      ]);

      
      try {
          $pieces = Pieces::create([
            'pieces' => $request->pieces,
          ]);
          return response()->json([
              'status' => 'success',
              'message' => 'pieces created successfully',
              'data' => $pieces
          ], 201);
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'pieces creation failed',
              'error' => $e->getMessage()
          ], 500);
      }
    }

    public function update(Request $request, $id)
    {

      $pieces = Pieces::findOrFail($id);

      if (!$pieces) {
          return response()->json([
              'status' => 'failed',
              'message' => 'pieces not found'
          ], 404);
      }

      try {
          $pieces->update([
            'pieces' => $request->pieces,
          ]);
          return response()->json([
              'status' => 'success',
              'message' => 'pieces updated successfully',
              'data' => $pieces
          ]);
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'pieces update failed',
              'error' => $e->getMessage()
          ], 500);
      }
    }

    public function delete($id)
    {
      $pieces = Pieces::find($id);

      if (!$pieces) {
          return response()->json([
              'status' => 'failed',
              'message' => 'pieces not found'
          ], 404);
      }
  
      try {
          $pieces->delete();
          return response()->json([
              'status' => 'success',
              'message' => 'pieces deleted successfully'
          ]);
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'pieces deletion failed',
              'error' => $e->getMessage()
          ], 500);
      }
    }
}
