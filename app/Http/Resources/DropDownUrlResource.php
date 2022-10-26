<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DropDownUrlResource extends JsonResource
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
            'enumerate_name' => $this->name,
            'url' => '/api/enumerate/'. $this->name .'/items',
        ];
    }
}
