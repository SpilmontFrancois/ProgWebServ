<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "lastname" => $this->lastname,
            "firstname" => $this->firstname,
            "login" => $this->login,
            "coordinates" => $this->coordinates,
            "contaminated" => $this->contaminated
        ];
    }
}
