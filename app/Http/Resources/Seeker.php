<?php

namespace App\Http\Resources;

use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Seeker extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => $this->user->password,
            'role' => $this->user->roles->pluck('name'),
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
