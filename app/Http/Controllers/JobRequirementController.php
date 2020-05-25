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
    public function show(JobRequirement $jobRequirement)
    {
        return new JobRequirementResource($jobRequirement);
    }

    public function store(Request $request)
    {
        $jobRequirement = $request->only(['name','job_id']);
        JobRequirement::create([
            'name'=>$jobRequirement['name'],
            'job_id'=>$jobRequirement['job_id'],
        ]);
        return response()->json('job requirement posted successful');
    }

    public function update(JobRequirement $jobRequirement, Request $request)
    {
        $update_jobRequirement = $request->only(['name','job_id']);
        $jobRequirement->update([
            'name'=>isset($update_jobRequirement['name']) ? $update_jobRequirement['name'] : $jobRequirement->name,
            'job_id'=>isset($update_jobRequirement['job_id']) ? $update_jobRequirement['job_id'] : $jobRequirement->job_id ,
        ]);
        return response()->json('job requirement updated successful');
    }

    public function destroy(JobRequirement $jobRequirement)
    {
        $jobRequirement->delete();
    }
}
