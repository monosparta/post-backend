<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'city' => $this->city,
            'zip_code' => $this->zip_code,
            'region' => $this->region,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
        ];
    }
}
