<?php

namespace App\Services;

use App\Models\Location;
use App\Models\Product;

class LocationService
{
	public function getLocations()
	{
		$locations = Location::with('products')->get();

		$locations->each(function (Location $location) {
			$location->products->each(function (Product $product) {
				$product->makeHidden(['id', 'category_id', 'location_id', 'created_at', 'updated_at']);
			});
		});

		return $locations;
	}

	public function getLocation(Location $location)
	{
		$location = Location::with('products')->find($location->id);

		if ($location) {
			$location->products->each(function (Product $product) {
				$product->makeHidden(['id', 'category_id', 'location_id', 'created_at', 'updated_at']);
			});
		}

		return $location;
	}

	public function create($data): Location
	{
		$location = new Location();

		$location->building = $data['building'];
		$location->row = $data['row'];
		$location->shelf = $data['shelf'];

		$location->save();

		return $location;
	}

	public function update(Location $location, $data): Location
	{
		$location->building = $data['building'];
		$location->row = $data['row'];
		$location->shelf = $data['shelf'];

		$location->save();

		return $location;
	}

	public function delete(Location $location): bool
	{
		$location->delete();
		return true;
	}
}

