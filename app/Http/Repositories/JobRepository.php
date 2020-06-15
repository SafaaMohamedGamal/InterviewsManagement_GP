<?php
namespace App\Http\Repositories;

use App\Job;
use App\JobRequirement;
use App\Http\Repositories\Interfaces\JobRepositoryInterface;

class JobRepository implements JobRepositoryInterface
{
    // * job function *
    public function getAllJobs($params)
    {
        // dd($params);
        $jobs = Job::where('available', $params['available']);
        !empty($params['minYears'])? $jobs->where('years_exp', '>=', $params['minYears']): null ;
        !empty($params['maxYears'])? $jobs->where('years_exp', '<=', $params['maxYears']): null ;
        !empty($params['seniority'])? $jobs->where('seniority', 'LIKE', "%{$params['seniority']}%"): null ;
        !empty($params['keyWord'])? $jobs->where(function ($query) use ($params) {
            $query->where('title', 'LIKE', "%{$params['keyWord']}%")->orwhere('description', 'LIKE', "%{$params['keyWord']}%");
        }):null;
        !empty($params['orderBy'])? $jobs->orderBy($params['orderBy'], $params['orderStyle']): null ;
        return $jobs->Ordered()->paginate($params['perPage']) ;
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
             'available'=> $job['available'] ? 1 : 0,
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
        // dd($updatedData);
        $job->update([
             'title'=> !empty($updatedData['title']) ? $updatedData['title'] : $job->title ,
             'description'=> !empty($updatedData['description']) ? $updatedData['description'] : $job->description,
             'available'=> $updatedData['available'] ? 1 : 0,
             'years_exp'=> !empty($updatedData['years_exp']) ? $updatedData['years_exp'] : $job->years_exp ,
             'seniority'=> !empty($updatedData['seniority']) ? $updatedData['seniority'] : $job->seniority,
         ]);
        $job->requirements()->delete();
        if (isset($updatedData['requirements'])) {
            foreach ($updatedData['requirements'] as $requirement) {
                $job->requirements()->create([
                    "name"=>$requirement
                ]);
            }
        }

        return $job;
    }
}
