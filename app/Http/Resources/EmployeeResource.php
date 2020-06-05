<?php

namespace App\Http\Resources;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'id'=> $this->id,
            'emp_id' => $this->id,
            'user' => new UserResource($this->user),
            'position' => $this->position,
            'branch' => $this->branch,
        ];
    }
}
