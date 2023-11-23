<?php

namespace App\Http\Controllers\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = ProductService::getProducts();

        return response()->json(array('data' => $products));
    }
    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), Product::CREATE_RULE, Product::CREATE_RULE_MESSAGE);
        if ($validator->fails()) {
            return response()->json(array('error' => $validator->errors()->first()), Response::HTTP_BAD_REQUEST);
        }
        $newProduct = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];
        $product = ProductService::createProduct($newProduct);

        return response()->json(array("message" => "Product created successfully"), Response::HTTP_CREATED);
    }
    public function detailProduct($id)
    {
        $product = ProductService::getProductById($id);

        if (!$product) {
            return response()->json(array("error" => "Product not found"), Response::HTTP_NOT_FOUND);
        }

        return response()->json($product);
    }
    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Product::CREATE_RULE, Product::CREATE_RULE_MESSAGE);
        if ($validator->fails()) {
            return response()->json(array('error' => $validator->errors()->first()), Response::HTTP_BAD_REQUEST);
        }
        $newProduct = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];
        try {
            $product = ProductService::updateProduct($id, $newProduct);
        } catch (\Throwable $th) {
            return response()->json(array('error' => $th->getMessage()), Response::HTTP_BAD_REQUEST);
        }

        return response()->json(array("message" => "Product updated successfully"), Response::HTTP_OK);
    }
    public function destroyProduct($id)
    {
        try {
            ProductService::deleteProduct($id);
        } catch (\Throwable $th) {
            return response()->json(array('error' => $th->getMessage()), Response::HTTP_BAD_REQUEST);
        }

        return response()->json(array("message" => "Product deleted successfully"), Response::HTTP_OK);
    }
}
