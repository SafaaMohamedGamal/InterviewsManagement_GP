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
}
