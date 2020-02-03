<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                    =>  $this->id,
            'name'                  =>  $this->name,
            'email'                 =>  $this->email,
            'organization'          =>  $this->organization,
            'contact_no'            =>  $this->contact_no,
            'password_is_default'   =>  $this->password_is_default
        ];
    }
}
