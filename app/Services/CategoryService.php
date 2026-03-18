<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class CategoryService
{
	public function getCategories()
	{
		$categories = Category::with('products')->get();

		$categories->each(function (Category $category) {
			$category->products->each(function (Product $product) {
				$product->makeHidden(['id', 'category_id', 'location_id', 'created_at', 'updated_at']);
			});
		});

		return $categories;
	}

	public function getCategory(Category $category)
	{
		$category = Category::with('products')->find($category->id);

		if ($category) {
			$category->products->each(function (Product $product) {
				$product->makeHidden(['id', 'category_id', 'location_id', 'created_at', 'updated_at']);
			});
		}

		return $category;
	}

	public function create($data): Category
	{
		$category = new Category();

		$category->name = $data['name'];
		$category->description = $data['description'] ?? null;

		$category->save();

		return $category;
	}

	public function update(Category $category, $data): Category
	{
		$category->name = $data['name'];
		$category->description = $data['description'] ?? null;

		$category->save();

		return $category;
	}

	public function delete(Category $category): bool
	{
		$category->delete();
		return true;
	}
}
