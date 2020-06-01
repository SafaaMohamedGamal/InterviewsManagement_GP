<?php

namespace App\Http\Controllers;

use App\Level;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Resources\LevelResource;
use App\Http\Requests\Interview\StoreLevelRequest;
use App\Http\Requests\Interview\UpdateLevelRequest;



class LevelController extends Controller
{
    
    public function index()
    {
        $level = Level::all();
        return LevelResource::collection($level);

    }

    public function store(StoreLevelRequest $request)
    {
        $level = Level::create($request->only(['name']));
        return new LevelResource($level);
    }

    
    public function show(Level $level)
    {
        return new LevelResource($level);
    }


    
    public function update(UpdateLevelRequest $request, Level $level)
    {
        $status = $level->update($request->only(['name']));
        return new LevelResource($level);
    }

    
    public function destroy($id)
    {
        $status = Level::destroy($id);
        if ($status) {
            return response()->json(["data" => "deleted successfuly"]);
        }
        return response()->json(["data" => "level doesn't exist"]);

    }
}
