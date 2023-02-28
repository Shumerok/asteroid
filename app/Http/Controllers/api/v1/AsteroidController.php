<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AsteroidRequest;
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
        return $this->service->createOrUpdate($this->service->getData());
    }

    public function fastest(AsteroidRequest $request): ResourceCollection|JsonResponse
    {
        $data = $request->validated();
        return $this->service->getFastestHazardous($data);
    }

    public function hazardous(): ResourceCollection|JsonResponse
    {
        return $this->service->getHazardous();
    }
}
