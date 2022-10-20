<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\UserDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDataResource extends JsonResource
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
            'post_id'=>$this->id,
            'title'=>$this->title,
            'content'=>$this->content,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'user'=> new UserDataResource($this->user)
        ];
    }
}
