<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Employee extends JsonResource
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
            'id' => $this->user->id,
            'emp_id' => $this->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'role' => $this->user->roles->pluck('name'),
    	      'position' => $this->position,
    	      'branch' => $this->branch,
        ];
    }
}
