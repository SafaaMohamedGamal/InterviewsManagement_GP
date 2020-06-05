<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Contact as ContactResource;

class SeekerResource extends JsonResource
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
            'user'=> new UserResource($this->user),
            'address' => $this->address,
            'city' => $this->city,
            'seniority' => $this->seniority,
            'expYears' => $this->expYears,
            'currentJob' => $this->currentJob,
            'currentSalary' => $this->currentSalary,
            'expectedSalary' => $this->expectedSalary,
            'cv' => $this->cv,
            'phone' => $this->phone,
            'isVerified' => $this->isVerified,
            'contacts' => ContactResource::collection($this->contacts)
        ];
    }
}
