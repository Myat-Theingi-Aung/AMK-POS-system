<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Arr;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $products = Product::when(request('search'), function($query){
            $search = '%' . request('search') . '%';
            $query->where('name','like', $search)
                  ->orWhere('price', 'like', $search)
                  ->orWhere('quantity', 'like', $search);
            })->orderBy('id','desc')->get();

        return ProductResource::collection($products);
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(ProductCreateRequest $request)
    {
        $product = Product::create($request->all());

        if($request->hasFile('image')){
            $path = $request->file('image')->store('images', 's3', 'public');
            $product->update([ 'image' => basename($path) ]);
        }

        return response()->json(['message' => 'Product created successfully','product' =>  new ProductResource($product)]);
    }

    /**
    * Display the specified resource.
    */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        if($request->hasFile('image')){
            $product->image ? $imagePath = 'images/' . $product->image : '';
            if(!is_null($imagePath) && Storage::disk('s3')->exists($imagePath)){
                Storage::disk('s3')->delete($imagePath);
            }
            $path = $request->file('image')->store('images', 's3', 'public');
            $product->update( ['image' => basename($path)] );
        }
        $product->update(Arr::except($request->except('image'), ['image']));

        return response()->json(['message' => 'Product updated successfully','product' =>  new ProductResource($product)]);  
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}