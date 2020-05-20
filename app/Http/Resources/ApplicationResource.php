<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'seeker'=>$this->seeker_id,
            'job'=>new JobResource($this->job),
            'status'=> new AppStatusResource($this->status)
        ];
    }
}
