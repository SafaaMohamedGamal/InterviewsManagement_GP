<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationsResource extends JsonResource
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
            'id'=>$this->id,
            'seeker'=>new SeekerResource($this->seeker) ,
            'job'=>new JobResource($this->job),
            'status'=> new AppStatusResource($this->status),
            'date'=>$this->updated_at,
        ];
    }
}
