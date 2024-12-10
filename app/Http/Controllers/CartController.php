<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
      {
        $id_user = Auth::user()->id;
        $cart = Cart::selectRaw('products.*, categories.category, brands.name_brand, pieces.pieces, carts.qty, carts.id as id_cart')->join('products', 'products.id', '=', 'carts.product_id')->join('categories', 'categories.id', '=', 'products.category_id')->join('pieces', 'pieces.id', '=', 'products.piace_id')->join('brands', 'brands.id', '=', 'products.brand_id')->where('user_id', $id_user)->get();
        return response()->json([
            'status' => $cart->isEmpty() ? 'failed' : 'success',
            'message' => $cart->isEmpty() ? 'No cart found' : 'cart retrieved successfully',
            'data' => $cart
        ]);
      }
  
      public function detail($id)
      {
        $cart = Cart::selectRaw('products.*, categories.category, brands.name_brand, pieces.pieces, carts.qty, carts.id as id_cart')->join('products', 'products.id', '=', 'carts.product_id')->join('categories', 'categories.id', '=', 'products.category_id')->join('pieces', 'pieces.id', '=', 'products.piace_id')->join('brands', 'brands.id', '=', 'products.brand_id')->where('carts.id', $id)->first();
        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart not found'
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'cart retrieved successfully',
            'data' => $cart
        ]);
      }
  
      public function insert(Request $request)
      {
        $request->validate([
            'qty' => 'required|string|max:255',
        ]);        

        try {

            $cart = Cart::create([
                'qty' => $request->qty,
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'cart created successfully',
                'data' => $cart
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
  
      public function update(Request $request, $id)
      {

        $cart = Cart::findOrFail($id);
  
        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart not found'
            ], 404);
        }

        try {
            $cart->update([
                'qty' => $request->qty,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'cart updated successfully',
                'data' => $cart
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart update failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
  
      public function delete($id)
      {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart not found'
            ], 404);
        }
    
        try {
            $cart->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'cart deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }


      public function delete_by_product($id)
      {
        $cart = Cart::where('product_id', $id)->delete();

        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart not found'
            ], 404);
        }
    
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'cart deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
      }
}
