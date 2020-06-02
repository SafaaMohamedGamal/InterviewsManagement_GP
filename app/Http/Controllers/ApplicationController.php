<?php

namespace App\Http\Controllers;

use App\Seeker;
use App\AppStatus;
use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $params=$request->all();
            $jobId =!empty($params['jobId'])?$params['jobId']:null;
            $expYears = !empty($params['expYears'])?$params['expYears']:null;
            $city = !empty($params['city'])?$params['city']:null;
            $exporder = !empty($params['exporder']) ? $params['exporder'] : null;

            $position = !empty($params['position']) ? $params['position'] : null;
            $seniority = !empty($params['seniority']) ? $params['seniority'] : null;
            $status = !empty($params['status']) ? $params['status'] : null;


            // $applications = !empty($params['jobId']) ? Application::where('job_id', $params['jobId'])->get() : Application::all();
            $applications = Application::
            when($jobId, function ($query, $jobId) {
                return $query->where('job_id', $jobId);
            })
            ->when($position, function ($query, $position) {
                $seeker = Seeker::select('id')->where('currentJob', 'LIKE', "%{$position}%");
                return $query->whereIn('seeker_id', $seeker);
            })
            ->when($seniority, function ($query, $seniority) {
                $seeker = Seeker::select('id')->where('seniority', 'LIKE', "%{$seniority}%");
                return $query->whereIn('seeker_id', $seeker);
            })
            ->when($status, function ($query, $status) {
                return $query->where('appstatus_id', $status);
            })
            ->when($expYears, function ($query, $expYears) {
                $seekers = Seeker::where('expYears', $expYears)->get('id');
                return $query->whereIn('seeker_id', $seekers);
            })
            ->when($city, function ($query, $city) {
                $seekers = Seeker::select('id')->where('city','like', "%{$city}%");
                return $query->whereIn('seeker_id', $seekers);
            })
            ->when($exporder, function ($query, $exporder) {
              return $query->join('seekers', 'seekers.id', '=', 'applications.seeker_id')
              ->orderBy('expYears', $exporder)
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
            'seeker_id' => $user->userable_id,
            'job_id' => $application['job_id'],
            'appstatus_id' => $status->id
        ]);

        return new ApplicationResource($newApp);
    }

    public function update(Application $application, Request $request)
    {
        $application->update([
            'appstatus_id' => $request->input('params')['status']
        ]);
        return response()->json('application update successful');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return response()->json('application deleted successful');
    }

}
