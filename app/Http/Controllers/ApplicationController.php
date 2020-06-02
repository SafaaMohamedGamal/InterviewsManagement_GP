<?php

namespace App\Http\Controllers;

use App\AppStatus;
use App\Application;
use App\Seeker;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\Application\StoreApplicationRequest;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        // dd(current_user()->hasRole('seeker'))
        if (current_user()->hasRole('seeker')) {
            $seekerId = current_user()->userable_id;
            $applications = Application::where('seeker_id', $seekerId)->get();
        } else {
            // dd($request);
            $params=$request->all();
            $jobId =!empty($params['jobId'])?$params['jobId']:null;
            $expYears = !empty($params['expYears'])?$params['expYears']:null;
            $city = !empty($params['city'])?$params['city']:null;
            $exporder = !empty($params['exporder']) ? $params['exporder'] : null;
            // $applications=!empty($params['jobId'])? Application::where('job_id', $params['jobId'])->get(): Application::all() ;

            $applications = Application::
                when($jobId, function ($query, $jobId) {
                    return $query->where('job_id', $jobId);
                })
                ->when($expYears, function ($query, $expYears) {
                    $seekers = Seeker::where('expYears', $expYears)->get('id');
                    return $query->whereIn('seeker_id', $seekers);
                })
                ->when($city, function ($query, $city) {
                    $seekers = Seeker::select('id')->where('city','like', "%{$expYears}%");
                    return $query->whereIn('seeker_id', $seekers);
                })
                ->when($exporder, function ($query, $exporder) {
                  return $query->join('seekers', 'seekers.id', '=', 'applications.seeker_id')
                  ->orderBy('expYears', 'desc')
                  ->select('applications.*');
              })
                ->get();
        }

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
        $application->update([
            'appstatus_id'=>$request->input('params')['status']
        ]);
        return response()->json('application update successful');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return response()->json('application deleted successful');
    }
}
