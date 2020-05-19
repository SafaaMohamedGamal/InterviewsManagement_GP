<?php

namespace App\Http\Controllers;

use App\JobRequirement;
use Illuminate\Http\Request;

use App\Http\Resources\JobRequirementResource;
use App\Http\Repositories\Interfaces\JobRepositoryInterface;

class JobRequirementController extends Controller
{
    public function index(JobRepositoryInterface $jobRebo, Request $request)
    {
        if ($request->query('job') != null) {
            $requirements = $jobRebo->getAllJobRequirements($request->query('job'));
        } else {
            $requirements = $jobRebo->getAllRequirements();
        }
        
        

        return JobRequirementResource::collection($requirements);
    }
    public function show(JobRequirement $job_requirement)
    {
        return new JobRequirementResource($job_requirement);
    }

    public function store(Request $request)
    {
        $job_requirement = $request->only(['name','job_id']);
        JobRequirement::create([
            'name'=>$job_requirement['name'],
            'job_id'=>$job_requirement['job_id'],
        ]);
        return response()->json('job requirement posted successful');
    }

    public function update(JobRequirement $job_requirement, Request $request)
    {
        $update_job_requirement = $request->only(['name','job_id']);
        $job_requirement->update([
            'name'=>isset($update_job_requirement['name']) ? $update_job_requirement['name'] : $job_requirement->name,
            'job_id'=>isset($update_job_requirement['job_id']) ? $update_job_requirement['job_id'] : $job_requirement->job_id ,
        ]);
        return response()->json('job requirement updated successful');
    }

    public function destroy(JobRequirement $job_requirement)
    {
        $job_requirement->delete();
    }
}
