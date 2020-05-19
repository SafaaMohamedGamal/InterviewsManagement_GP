<?php
namespace App\Http\Repositories;

use App\Job;
use App\Http\Repositories\Interfaces\JobRepositoryInterface;

class JobRepository implements JobRepositoryInterface
{
    public function getAllProducts()
    {
        return Job::all() ;
    }
}
