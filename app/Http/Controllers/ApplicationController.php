<?php

namespace App\Http\Controllers;

use App\AppStatus;
use App\Application;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\Application\StoreApplicationRequest;

class ApplicationController extends Controller
{
    public function index()
    {
        $seekerId = current_user()->userable_id;
        $applications = Application::where('seeker_id', $seekerId)->get();
        return ApplicationResource::collection($applications);
    }

    public function show(Application $application)
    {
        return new ApplicationResource($application);
    }

    public function store(StoreApplicationRequest $request)
    {
        $application = $request->only(['job_id']);
        $user = current_user();
        $status = AppStatus::newStatus();
        
        $newApp = Application::create([
            'seeker_id'=>$user->userable_id,
                'job_id'=>$application['job_id'],
                'appstatus_id'=>$status->id
        ]);
        
        return new ApplicationResource($newApp);
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
