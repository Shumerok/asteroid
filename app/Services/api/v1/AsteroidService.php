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
    const  API_KEY = 'unyceRDg4WwIvfHwBxZKWjzUCAZZVcHRaBZ16CXw';
    private string $nowDate;
    private string $threeDayAgo;
    private array $formattedArray;

    public function __construct()
    {
        $this->nowDate = date('Y-m-d');
        $this->threeDayAgo = date('Y-m-d', strtotime('-3 day'));
        $this->formattedArray = [];
    }

    public function getData()
    {
        return $this->JsonToArray();
    }

    public function createOrUpdate(array $asteroids): void
    {
        $transformToDbColumn = [];
        foreach ($asteroids as $asteroid) {
            $transformToDbColumn[] = [
                'referenced' => $asteroid['neo_reference_id'],
                'name' => $asteroid['name'],
                'speed' => $asteroid['kilometers_per_hour'],
                'is_hazardous' => $asteroid['is_potentially_hazardous_asteroid'],
                'date' => $asteroid['close_approach_date']
            ];
        }
        foreach ($transformToDbColumn as $value) {
            Asteroid::upsert($value, 'referenced', ['name', 'speed', 'is_hazardous', 'date']);
        }
    }

    public function getFastestHazardous(?array $data): ResourceCollection|JsonResponse
    {
        if (empty($data)) {
            $asteroids = Asteroid::orderBy('speed', 'desc')->get();
            return AsteroidResource::collection($asteroids);
        }

        if ($data['hazardous'] === 'true') {
            $asteroids = Asteroid::where('is_hazardous', 1)->orderBy('speed', 'desc')->get();
            return $this->emptyHazardous($asteroids);
        }

        if ($data['hazardous'] === 'false') {
            $asteroids = Asteroid::where('is_hazardous', 0)->orderBy('speed', 'desc')->get();
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
    private function JsonToArray(): array
    {
        $jsonNasa = file_get_contents(
            "https://api.nasa.gov/neo/rest/v1/feed?"
            ."start_date=$this->threeDayAgo"
            ."&end_date=$this->nowDate"
            .'&api_key='.self::API_KEY
        );

        $decodeJsonNasa = json_decode($jsonNasa, true);
        $elements = $decodeJsonNasa['near_earth_objects'];
        $asteroids = [];

        foreach ($elements as $value) {
            foreach ($value as $element) {
                $asteroids[] = self::keyValueExtractor($element);
            }
        }

        return $asteroids;
    }

    private function keyValueExtractor($json): array
    {
        foreach ($json as $key => $value) {
            if (is_array($value)) {
                self::keyValueExtractor($value);
            } else {
                if (empty($value)) {
                    $value = 0;
                    $this->formattedArray[$key] = $value;
                }
                $this->formattedArray[$key] = $value;
            }
        }

        return $this->formattedArray;
    }
}

