<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'name' => $this->name,
            'vat' => $this->vat,
            'phone_country_code' => $this->phone_country_code,
            'phone_country_calling_code' => $this->phone_country_calling_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address ? new AddressResource($this->address) : [
                'city' => null,
                'state' => null,
                'zip_code' => null,
                'street' => null,
            ],
        ];
    }
}
