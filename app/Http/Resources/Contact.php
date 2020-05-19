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
            'seeker_id' => $this->seeker_id,
            'data' => $this->data,
            'contact_type' => $this->contactType->type,
        ];
    }
}
