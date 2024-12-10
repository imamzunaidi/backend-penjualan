<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Peace;
use File;

class ProductController extends Controller
{

      public function index()
      {
          $products = Product::selectRaw('products.*, categories.category, brands.name_brand, pieces.pieces')->join('categories', 'categories.id', '=', 'products.category_id')->join('pieces', 'pieces.id', '=', 'products.piace_id')->join('brands', 'brands.id', '=', 'products.brand_id')->get();
          return response()->json([
              'status' => 'success',
              'message' => 'Products retrieved successfully',
              'data' => $products
          ]);
      }
  
      public function detail($id)
      {
          $product = Product::selectRaw('products.*, categories.category, brands.name_brand, pieces.pieces')->join('categories', 'categories.id', '=', 'products.category_id')->join('pieces', 'pieces.id', '=', 'products.piace_id')->join('brands', 'brands.id', '=', 'products.brand_id')->where('products.id',$id)->first();
  
          if (!$product) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Product not found'
              ], 404);
          }
  
          return response()->json([
              'status' => 'success',
              'message' => 'Product retrieved successfully',
              'data' => $product
          ]);
      }
  
      public function insert(Request $request)
      {
          $request->validate([
              'name_product' => 'required|string|max:255',
              'category_id' => 'required|exists:categories,id',
              'brand_id' => 'required|exists:brands,id',
            //   'piace_id' => 'required|exists:peaces,id',
              'description' => 'nullable|string',
              'price' => 'required|numeric'
          ]);
  
          try {
                $lastProduct = Product::latest()->first();
                $lastCode = $lastProduct ? (int) substr($lastProduct->code_product, 1) : 0;
                $newCode = 'P' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);


                $image = $request->file('image');
                $nama_document = time()."_".$image->getClientOriginalName();
                $tujuan_upload = 'product';
        
                $image->move($tujuan_upload,$nama_document);
    
                $data = [
                    'code_product' => $newCode,
                    'name_product' => $request->name_product,
                    'price' => $request->price,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'piace_id' => $request->piace_id,
                    'description' => $request->description,
                    'image' => $nama_document,
                ];

                $product = Product::create($data);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product created successfully',
                    'data' => $product
                ], 201);
          } catch (\Exception $e) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product creation failed',
                    'error' => $e->getMessage()
                ], 500);
          }
      }
  
      public function update(Request $request, $id)
      {
          $product = Product::find($id);
  
          if (!$product) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Product not found'
              ], 404);
          }
  
        //   $request->validate([
        //       'name' => 'required|string|max:255',
        //       'category_id' => 'required|exists:categories,id',
        //       'brand_id' => 'required|exists:brands,id',
        //     //   'peace_id' => 'required|exists:peaces,id',
        //       'description' => 'nullable|string',
        //       'price' => 'required|numeric'
        //   ]);
  
          try {
                $data = [
                    'name_product' => $request->name_product,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'peace_id' => $request->peace_id,
                    'description' => $request->description,
                ];
                $product->update($data);


                $image = $request->file('image');

                if ($image == null || $image == '') {
                    $data = [
                        'name_product' => $request->name_product,
                        'category_id' => $request->category_id,
                        'brand_id' => $request->brand_id,
                        'peace_id' => $request->peace_id,
                        'description' => $request->description,
                    ];
                    $product->update($data);
                } else {
                    File::delete('product/'.$product->image);

                    $nama_document = time()."_".$image->getClientOriginalName();
                    $tujuan_upload = 'product';
                    $image->move($tujuan_upload,$nama_document);

                    $data = [
                        'name_product' => $request->name_product,
                        'category_id' => $request->category_id,
                        'brand_id' => $request->brand_id,
                        'peace_id' => $request->peace_id,
                        'description' => $request->description,
                        'image' => $nama_document,
                    ];

                    $product->update($data);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product updated successfully',
                    'data' => $product
                ]);
          } catch (\Exception $e) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Product update failed',
                  'error' => $e->getMessage()
              ], 500);
          }
      }
  
      public function delete($id)
      {
          $product = Product::find($id);
  
          if (!$product) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Product not found'
              ], 404);
          }
  
          try {
              $product->delete();
              return response()->json([
                  'status' => 'success',
                  'message' => 'Product deleted successfully'
              ]);
          } catch (\Exception $e) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Product deletion failed',
                  'error' => $e->getMessage()
              ], 500);
          }
      }
}
