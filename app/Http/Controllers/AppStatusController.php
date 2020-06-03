<?php

namespace App\Http\Controllers;

use App\AppStatus;
use Illuminate\Http\Request;
use App\Http\Resources\AppStatusResource;
use App\Http\Requests\Application\StoreStatusRequest;

class AppStatusController extends Controller
{
    public function index()
    {
        return AppStatusResource::collection(AppStatus::all());
    }

    public function show(AppStatus $appstatus)
    {
        return new AppStatusResource($appstatus);
    }

    public function store(StoreStatusRequest $request)
    {
        // dd($request);
        $appstatus = $request->only(['name','description']);
        AppStatus::create([
            'name'=>$appstatus['name'],
            'description'=>$appstatus['description'],
        ]);
        return response()->json('status posted successful');
    }

    public function update(AppStatus $appstatus, StoreStatusRequest $request)
    {
        $updateAppStatus = $request->only(['name','description']);

        $newStatus = AppStatus::newStatus();
        if ($newStatus==$appstatus && $updateAppStatus['name'] != $appstatus->name) {
            return response()->json(['error' => 'sorry u cant delete new status or rename it'], 422);
        }
        
        $appstatus->update([
            'name'=>$updateAppStatus['name'],
            'description'=>$updateAppStatus['description'],
        ]);
        return response()->json('status updated successful');
    }

    public function destroy(AppStatus $appstatus)
    {
        $newStatus = AppStatus::newStatus();
        if ($newStatus==$appstatus) {
            return response()->json(['error' => 'sorry u cant delete new status or rename it'], 422);
        }
        
        $appstatus->delete();
        return response()->json('status deleted successful');
    }
}
