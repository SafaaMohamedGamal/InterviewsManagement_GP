<?php

namespace App\Http\Controllers\Contact;

use App\Contact;
use App\ContactType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = Contact::all();
        return response()->json([
            "data" => $contact,
            "status" => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = $request->only(['data', 'seeker_id', 'contact_types_id']);
        $contact_type = ContactType::find($contact['contact_types_id']);
        $contact = new Contact([
            'data' => $contact['data'],
            'seeker_id' => $contact['seeker_id']
        ]);
        $contact->contactTypes()->associate($contact_type);
        $contact = $contact->save();
        return response()->json([
            "data" => $contact,
            "status" => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        return response()->json([
            "data" => Contact::find($id),
            "contact_type" => $contact->contactTypes()->get(),
            "status" => 200
        ]);
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
        $contactReq = $request->only(['data', 'seeker_id', 'contact_types_id']);
        $contact = Contact::find($id);
        $contact->update([
            'data' => isset($contactReq['data']) ? $contactReq['data'] : $contact['data'],
            'seeker_id' => isset($contactReq['seeker_id']) ? $contactReq['seeker_id'] : $contact['seeker_id'],
        ]);
        if(isset($contactReq['contact_types_id'])){
            $contact_type = ContactType::find($contactReq['contact_types_id']);
            $contact->contactTypes()->associate($contact_type);
            $contact = $contact->save();
        }
        return response()->json([
            "data" => $contact,
            "status" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([
            "data" => Contact::destroy($id),
            "status" => 200
        ]);
    }
}
