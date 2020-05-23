<?php

namespace App\Http\Controllers;

use App\AppStatus;
use App\Application;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;

class ApplicationController extends Controller
{
    public function index()
    {
        return ApplicationResource::collection(Application::all());
    }

    public function show(Application $application)
    {
        return new ApplicationResource($application);
    }

    public function store(Request $request)
    {
        // dd(AppStatus::newStatus()) ;
        $application = $request->only(['user_id','job_id']);
        $status = AppStatus::newStatus();
        
        Application::create([
            'seeker_id'=>$application['user_id'],
                'job_id'=>$application['job_id'],
                'appstatus_id'=>$status->id
        ]);
        
        return response()->json('application posted successful');
    }

    public function update(Application $application, Request $request)
    {
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return response()->json('application deleted successful');
    }
}
