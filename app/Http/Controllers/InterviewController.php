<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InterviewResource;
use App\Interview;
use App\Http\Requests;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

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
    public function store(Request $request)
    {
        $interview = new Interview;
        $interview->application_id = $request->input('application_id');
        $interview->emp_id = $request->input('emp_id');
        $interview->level_id = $request->input('level_id');
        $interview->date = $request->input('date');
        $interview->seeker_review = " ";
        $interview->company_review = " ";
        $interview->zoom = $request->input('zoom');
        $interview->save();


        $event = new Event;
        $event->name = 'A new event'.$interview->emp_id;
        $event->title = 'A new event2';
        $event->startDateTime = Carbon::now();
        $event->endDateTime = Carbon::now()->addHour();
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
        if( $interview ){
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
        if($interview->delete()){
            return  new InterviewResource($interview);
        }
        return "Error while deleting";
    }
}
