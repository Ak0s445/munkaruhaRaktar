<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Gate;

class LocationController extends Controller
{
	use ResponseTrait;

	public function __construct(protected LocationService $locationService)
	{
	}

	public function getLocations()
	{
		Gate::authorize('viewAny', Location::class);
		$locations = $this->locationService->getLocations();
		return $this->sendResponse($locations, 'Helyek lekérve.');
	}

	public function getLocation(Location $location)
	{
		Gate::authorize('view', $location);
		$location = $this->locationService->getLocation($location);
		return $this->sendResponse($location, 'Hely lekérve.');
	}

	public function create(LocationRequest $request, LocationService $locationService)
	{
		Gate::authorize('create', Location::class);

		$validated = $request->validated();

		$location = $locationService->create($validated);
		return $this->sendResponse($location, 'Hely létrehozva.');
	}

	public function update(LocationRequest $request, Location $location, LocationService $locationService)
	{
		Gate::authorize('update', $location);

		$validated = $request->validated();

		$location = $locationService->update($location, $validated);
		return $this->sendResponse($location, 'Hely frissítve.');
	}

	public function delete(Location $location, LocationService $locationService)
	{
		Gate::authorize('delete', $location);
		$deleted = $locationService->delete($location);
		return $this->sendResponse($deleted, 'Hely törölve.');
	}
}
