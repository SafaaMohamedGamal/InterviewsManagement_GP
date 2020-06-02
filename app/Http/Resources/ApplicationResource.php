<?php

namespace App\Http\Resources;

// use App\Http\Resources\Seeker;
use App\Http\Resources\SeekerResource;
use App\Http\Resources\InterviewResource;
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
            'id'=>$this->id,
            'seeker'=>new SeekerResource($this->seeker) ,
            'job'=>new JobResource($this->job),
            'status'=> new AppStatusResource($this->status),
            'interviews'=> InterviewResource::collection($this->interviews()->orderby('date')->get()),
        ];
    }
}
