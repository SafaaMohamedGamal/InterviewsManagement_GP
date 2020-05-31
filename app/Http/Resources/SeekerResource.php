<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'user'=> new User($this->user)
        ];
    }
}
