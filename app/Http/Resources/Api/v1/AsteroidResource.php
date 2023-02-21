<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AsteroidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'referenced'=>$this->referenced,
            'name'=>$this->name,
            'speed'=>$this->speed,
            'is_hazardous'=>$this->is_hazardous,
            'date'=>$this->date,
            'created_at'=>$this->created_at->format('Y-m-d H:i:s'),
            'updated_at'=>$this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
