<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResource extends JsonResource
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
            'application_id' => $this->application_id,
            'emp_id' => $this->emp_id,
            'emp_name' => $this->employee->user->name,
            'level_id' =>$this->level_id,
            'level_name' => $this->level->name,
            'date' => $this->date,
            'seeker_review' => $this->seeker_review,
            'company_review' => $this->company_review,
            'zoom' => $this->zoom,
            'seeker'=>$this->application->seeker->user->name,
            'seeker_id'=>$this->application->seeker->user->id,
            'job'=>$this->application->job->title
        ];
    }
}
