<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DropDownItemResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'value' => $this->value,
            'value_alt' => $this->value_alt,
            'value_alt_2' => $this->value_alt_2,
            'sequence' => $this->sequence,
            'is_enabled' => $this->is_enabled ? true : false,
        ];
    }
}
