<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
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
            'username' => $this->name,
            'status' => 'Active',
            'categories' => $this->userCategories->count() > 0 ? new UserCategoryResource($this->userCategories[0]) : null,
            'email' => $this->email,
            'mobile' => $this->mobile_country_calling_code . $this->mobile,
        ];
    }
}
