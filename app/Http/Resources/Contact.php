<?php

namespace App\Http\Resources;

use App\Http\Resources\ContactType as ContactTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Contact extends JsonResource
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
            'id' => $this->id,
            'seeker_id' => $this->seeker->user->id,
            'seeker_name' => $this->seeker->user->name,
            'data' => $this->data,
            'contact_types_id' => $this->contactType->id,
            'contact_type' => $this->contactType->type,
        ];
    }
}
