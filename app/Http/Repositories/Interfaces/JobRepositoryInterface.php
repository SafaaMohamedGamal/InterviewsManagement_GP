<?php
namespace App\Http\Repositories\Interfaces;

interface JobRepositoryInterface
{
    //  * Jobs functions *
    public function getAllJobs();

    // public function filterAllJobs();

    // * requirements functions *
    public function getAllRequirements();
    public function getAllJobRequirements($job);

    public function createJob($request);
    public function updateJob($updatedData, $job);
}
