<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Http\Repositories\Interfaces\JobRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    private $jobRebo;
    public function __construct(JobRepositoryInterface $jobRebository)
    {
        $this->jobRebo = $jobRebository;
    }

    public function index(Request $request)
    {
        $jobs = $this->jobRebo->getAllJobs($request->all());
        return JobResource::collection($jobs);
    }
    public function show(Job $job)
    {
        return  new JobResource($job);
    }

    public function store(StoreJobRequest $request)
    {
        $job = $request->only(['title', 'description','available','years_exp','seniority','requirements']);
        $newJob=$this->jobRebo->createJob($job);
        
        return new JobResource($newJob);
        // return response()->json('job posted successful');
    }

    public function update(Request $request, Job $job)
    {
        $newData = $request->only(['title', 'description','available','years_exp','seniority','requirements']);
        $Updatedjob = $this->jobRebo->updateJob($newData, $job);
        return new JobResource($job);
        // return response()->json('job updated successful');
    }

    public function destroy(Job $job)
    {
        if ($job->delete()) {
            return response()->json('job deleted successful');
        } else {
            return response()->json('not');
        }
    }
}
