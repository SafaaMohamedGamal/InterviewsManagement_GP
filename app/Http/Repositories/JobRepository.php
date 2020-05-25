<?php
namespace App\Http\Repositories;

use App\Job;
use App\JobRequirement;
use App\Http\Repositories\Interfaces\JobRepositoryInterface;

class JobRepository implements JobRepositoryInterface
{
    // * job function *
    public function getAllJobs()
    {
        return Job::all() ;
    }

    // * requirements functions  *
    public function getAllRequirements()
    {
        return JobRequirement::all();
    }

    public function getAllJobRequirements($job)
    {
        return JobRequirement::where('job_id', $job)->get();
    }

    public function createJob($job)
    {
        $new_job = Job::create([
             'title'=> $job['title'],
             'description'=> $job['description'],
             'available'=> isset($job['available']) ? 1 : 0,
             'years_exp'=> $job['years_exp'],
             'seniority'=> $job['seniority']
         ]);
        if (isset($job['requirements'])) {
            foreach ($job['requirements'] as $requirement) {
                $new_job->requirements()->create([
                    "name"=>$requirement
                ]);
            }
        }
        return $new_job;
    }

    public function updateJob($updatedData, $job)
    {
        $job->update([
             'title'=> isset($updatedData['title']) ? $updatedData['title'] : $job->title ,
             'description'=> isset($updatedData['description']) ? $updatedData['description'] : $job->description,
             'available'=> isset($updatedData['available']) ? $updatedData['available'] : $job->available,
             'years_exp'=> isset($updatedData['years_exp']) ? $updatedData['years_exp'] : $job->years_exp ,
             'seniority'=> isset($updatedData['seniority']) ? $updatedData['seniority'] : $job->seniority,
         ]);

        return $job;
    }
}
