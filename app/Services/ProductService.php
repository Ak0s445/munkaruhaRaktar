<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\ResponseTrait;

class ProductService
{
	use ResponseTrait;

	public function getProducts()
	{
		$products = Product::with('category', 'location')->get();
		return (ProductResource::collection($products));
	}

	public function getProduct(Product $product)
	{
		$product = Product::with('category', 'location')->find($product->id);
		return (new ProductResource($product));
	}

	public function create($data): ProductResource
	{
		$product = new Product();

		$product->name = $data['name'];
		$product->description = $data['description'] ?? null;
		$product->category_id = $data['category_id'];
		$product->location_id = $data['location_id'];
		$product->quantity = $data['quantity'];
		$product->size = $data['size'];

		$product->save();

		return (new ProductResource($product));
	}

	public function update(Product $product, $data): ProductResource
	{
		$product->name = $data['name'];
		$product->description = $data['description'] ?? null;
		$product->category_id = $data['category_id'];
		$product->location_id = $data['location_id'];
		$product->quantity = $data['quantity'];
		$product->size = $data['size'];

		$product->save();

		return (new ProductResource($product));
	}

	public function delete(Product $product): bool
	{
		$product->delete();
		return true;
	}
}

