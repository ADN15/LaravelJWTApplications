<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Validator;


class ProductController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['listProduct', 'addProduct','deleteProduct','productById']]);
    }

    /**
     * Get the list Product.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listProduct() {
        $data = Product::get();
        return response()->json([
            'message' => 'Success',
            'data'=>$data
        ], 201);
    }
  
     /**
     * Remove the specified resource from storage.
     
     * @return \Illuminate\Http\JsonResponse
     */
    public function productById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        $data = Product::where(array_merge(
            $validator->validated(),
        ))->get();
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        return response()->json([
            'message' => 'Success',
            'data'=>$data
        ], 201);
       
    }
    /**
     * Remove the specified resource from storage.
     
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            
        ]);
        $action = Product::destroy(array_merge(
            $validator->validated(),
        ));
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        return response()->json([
            'message' => 'Product successfully delete',
        ], 201);
       
    }

    /**
     * Add a New Product.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'sku' => 'required|string|between:2,100',
            'brand' => 'required|string|between:2,100',
            'deskripsi' => 'required|string|between:2,100',
            'variasi' => 'required|string|between:2,100',
            'price' => 'required|string|between:2,100',
            'stok' => 'nullable',
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Product::create(array_merge(
                    $validator->validated(),
                ));

        return response()->json([
            'message' => 'Product successfully Add',
            'product' => $product
        ], 201);
    }

}

    
