<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InterviewResource;
use App\Interview;
use App\Http\Requests;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use App\Http\Requests\StoreInterviewRequest;

class InterviewController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interview = Interview::all();

        // dd($interview[2]->application->seeker->user->name);
        
        // $event = new Event;
        // $event->name = 'A new event';
        // $event->title = 'A new event2';
        // $event->startDateTime = Carbon::now();
        // $event->endDateTime = Carbon::now()->addHour();
        // $event->save();
        

        return InterviewResource::collection($interview);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInterviewRequest $request)
    {
         $request = $request->only(['application_id','employee_id','level_id','date','zoom']);
        $interview=Interview::create([
            'application_id'=> $request['application_id'],
            'emp_id' =>$request['employee_id'],
            'level_id'=>$request['level_id'],
            'zoom'=>$request['zoom'],
            'date'=>$request['date'],
            'company_review'=>$request['company_review'],
            'daseeker_reviewte'=>$request['seeker_review'],
        ]);


        $event = new Event;
        $event->name = "interview assigned to "
            .$interview->employee->user->name
            ." ID(".$interview->emp_id.")"
            ."with seeker ".$interview->application->seeker->user->name
            ." app ID".$interview->application_id;
        // $event->startDateTime = Carbon::now();
        $event->startDateTime = Carbon::parse($interview->date);

        $event->endDateTime = Carbon::parse($interview->date)->addHour();
        $event->save();


        return new InterviewResource($interview);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interview = Interview::find($id); //id comes from route
        if ($interview) {
            return new InterviewResource($interview);
        }
        return "interview Not found"; // temporary error
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $interview = Interview::find($id);
        $interview->application_id = !empty($request->input('application_id'))?$request->input('application_id'):$interview->application_id;
        $interview->emp_id = !empty($request->input('emp_id'))?$request->input('emp_id'):$interview->emp_id;
        $interview->level_id = !empty($request->input('level_id'))?$request->input('level_id'):$interview->level_id;
        $interview->date =!empty($request->input('date'))?$request->input('date'):$interview->date;
        $interview->seeker_review = !empty($request->input('seeker_review'))?$request->input('seeker_review'):$interview->seeker_review;
        $interview->company_review =!empty($request->input('company_review'))?$request->input('company_review'):$interview->company_review;
        $interview->zoom = !empty($request->input('zoom'))?$request->input('zoom'):$interview->zoom;
        $interview->save();
        return new InterviewResource($interview);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interview = Interview::findOrfail($id);
        if ($interview->delete()) {
            return  new InterviewResource($interview);
        }
        return "Error while deleting";
    }
}
