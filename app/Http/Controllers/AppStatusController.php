<?php

namespace App\Http\Controllers;

use App\AppStatus;
use Illuminate\Http\Request;
use App\Http\Resources\AppStatusResource;

class AppStatusController extends Controller
{
    public function index()
    {
        return AppStatusResource::collection(AppStatus::all());
    }

    public function show(AppStatus $appStatus)
    {
        return new AppStatusResource($appStatus);
    }

    public function store(Request $request)
    {
        // dd($request);
        $appStatus = $request->only(['name','description']);
        AppStatus::create([
            'name'=>$appStatus['name'],
            'description'=>$appStatus['description'],
        ]);
        return response()->json('status posted successful');
    }

    public function update(AppStatus $appStatus, Request $request)
    {
        $updateAppStatus = $request->only(['name','description']);
        $appStatus->update([
            'name'=>isset($updateAppStatus['name']) ? $updateAppStatus['name'] : $appStatus['name'],
            'description'=>isset($updateAppStatus['description']) ? $updateAppStatus['description'] : $appStatus['description'] ,
        ]);
        return response()->json('status updated successful');
    }

    public function destroy(AppStatus $appStatus)
    {
        $appStatus->delete();
        return response()->json('status deleted successful');
    }
}
