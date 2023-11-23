<?php

namespace App\Services;

use App\Models\Product;
use Error;

class ProductService
{
    protected static $product;

    public static function getProducts()
    {
        $products = Product::all();

        return $products;
    }

    public static function createProduct($dataProduct)
    {
        $product = Product::create($dataProduct);

        return $product;
    }

    public static function getProductById($id)
    {
        $product = Product::find($id);

        return $product;
    }

    public static function updateProduct($id, $dataProduct)
    {
        $product = self::getProductById($id);
        if (!$product) {
            throw new Error("Product not found");
        }
        $product->update($dataProduct);

        return $product;
    }

    public static function deleteProduct($id)
    {
        $product = self::getProductById($id);
        if (!$product) {
            throw new Error("Product not found");
        }
        $product->delete();
    }
}
