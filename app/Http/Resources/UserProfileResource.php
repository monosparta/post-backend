<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'categories' => $this->userCategories->count() > 0 ? new UserCategoryResource($this->userCategories[0]) : null,
            'first_name' => $this->profile->first_name,
            'last_name' => $this->profile->last_name,
            'middle_name' => $this->profile->middle_name,
            'birth_date' => $this->profile->birth_date,
            'gender' => $this->profile->gender,
            'job_title' => $this->profile->job_title,
            'phone_country_code' => $this->profile->phone_country_code,
            'phone_country_calling_code' => $this->profile->phone_country_calling_code,
            'phone' => $this->profile->phone,
            'nationality' => $this->profile->nationality,
            'identity_code' => $this->profile->identity_code,
            'address' => $this->profile->address ? new AddressResource($this->profile->address) : [
                'city' => null,
                'state' => null,
                'zip_code' => null,
                'street' => null,
            ],
        ];
    }
}
