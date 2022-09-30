<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
            'custom_id' => $this->custom_id,
            'email' => $this->email,
            'username' => $this->name,
            'full_name' => $this->full_name,
            'mobile_country_code' => $this->mobile_country_code,
            'mobile_country_calling_code' => $this->mobile_country_calling_code,
            'mobile' => $this->mobile,
            'email_verify' => $this->email_verified_at ? true : false,
            'mobile_verify' => false,
        ];
    }
}
