<?php

declare(strict_types=1);

namespace App\Services\api\v1;

use App\Http\Resources\Api\v1\AsteroidResource;
use App\Models\Asteroid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AsteroidService
{

    public function getData()
    {
        return $this->JsonToArray();
    }

    public function createOrUpdate(Collection $asteroids): JsonResponse
    {
        foreach ($asteroids->all() as $asteroid) {
            Asteroid::upsert($asteroid, 'referenced', ['name', 'speed', 'is_hazardous', 'date']);
        }

        return response()->json(['Data set' => 'Success']);
    }

    public function getFastestHazardous(?array $data): ResourceCollection|JsonResponse
    {
        if (empty($data)) {
            $asteroids = Asteroid::orderBy('speed', 'desc')->get();
            return AsteroidResource::collection($asteroids);
        }

        if (!$data['hazardous']) {
            $asteroids = Asteroid::where('is_hazardous', false)->orderBy('speed', 'desc')->get();
        }

        if ($data['hazardous']) {
            $asteroids = Asteroid::where('is_hazardous', true)->orderBy('speed', 'desc')->get();
            return $this->emptyHazardous($asteroids);
        }

        return AsteroidResource::collection($asteroids);
    }

    public function emptyHazardous(Collection $hazard): JsonResponse|ResourceCollection
    {
        if ($hazard->isEmpty()) {
            return response()->json(['FYI' => "There are no hazardous asteroids"]);
        }
        return AsteroidResource::collection($hazard);
    }

    public function getHazardous(): ResourceCollection|JsonResponse
    {
        $asteroids = Asteroid::where('is_hazardous', 1)->get();
        return $this->emptyHazardous($asteroids);
    }

    private function JsonToArray(): Collection
    {
        $jsonNasa = file_get_contents(
            'https://api.nasa.gov/neo/rest/v1/feed?'
            .'start_date='.config('asteroid.date_before')
            .'&end_date='.config('asteroid.date_now')
            .'&api_key='.config('asteroid.api_key')
        );

        $decodeJsonNasa = json_decode($jsonNasa);
        $collection = new Collection($decodeJsonNasa);

        $days = $collection->get('near_earth_objects');
        $asteroids = new Collection();

        foreach ($days as $day) {
            foreach ($day as $element) {
                $data = $element->close_approach_data[0];
                $asteroids->put(null, [
                    'referenced' => $element->neo_reference_id,
                    'name' => $element->name,
                    'speed' => $data->relative_velocity->kilometers_per_hour,
                    'is_hazardous' => $element->is_potentially_hazardous_asteroid,
                    'date' => $data->close_approach_date
                ]);
            }
        }

        return $asteroids;
    }
}

