<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
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
            'info' => [
                'custom_id' => $this->custom_id,
                'username' => $this->name,
                'email' => $this->email,
                'mobile_country_code' => $this->mobile_country_code,
                'mobile_country_calling_code' => $this->mobile_country_calling_code,
                'mobile' => $this->mobile,
                'full_name' => $this->full_name ?? null,
                'email_verify' => $this->email_verified_at ? true : false,
                'mobile_verify' => false,
            ],
            'profile' => $this->profile ? new UserProfileResource($this) : null,
            'organization' => $this->organization ? new OrganizationResource($this->organization) : null,
            'emergency_contact' => $this->emergencyContacts->count() > 0 ? new EmergencyContactsResource($this->emergencyContacts[0]) : null,
        ];
    }
}
