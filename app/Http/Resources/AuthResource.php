<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'message' => $this['message'],
            'data' => [
                'user' => [
                    'id' => $this['user']->id,
                    'email' => $this['user']->email,
                    'username' => $this['user']->username,
                    'mobile_country_code' => $this['user']->mobile_country_code,
                    'mobile_country_calling_code' => $this['user']->mobile_country_calling_code,
                    'mobile' => $this['user']->mobile,
                ],
                'token' => [
                    'token_type' => 'Bearer',
                    'access_token' => $this['access_token']->plainTextToken,
                    'access_token_expires_at' => $this['access_token']->accessToken->expires_at,
                    'refresh_token' => $this['refresh_token']->plainTextToken,
                    'refresh_token_expires_at' => $this['refresh_token']->accessToken->expires_at,
                ],
            ],
        ];
    }
}
