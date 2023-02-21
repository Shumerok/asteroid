<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AsteroidRequest;
use App\Http\Resources\Api\v1\AsteroidResource;
use App\Models\Asteroid;
use App\Services\api\v1\AsteroidService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AsteroidController extends Controller
{
    private AsteroidService $service;

    public function __construct(AsteroidService $service)
    {
        $this->service = $service;
    }

    public function getData(): JsonResponse
    {
        $this->service->createOrUpdate($this->service->getData());
        return response()->json(['Data set' => 'Success']);
    }

    public function fastest(AsteroidRequest $request): ResourceCollection
    {
        $data = $request->validated();
        return $this->service->getFastestHazardous($data);
    }

    public function hazardous(): ResourceCollection
    {
        $asteroids = Asteroid::where('is_hazardous', 1)->get();
        return AsteroidResource::collection($asteroids);
    }
}
