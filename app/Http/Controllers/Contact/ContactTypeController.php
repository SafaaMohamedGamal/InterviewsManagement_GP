<?php

namespace App\Http\Controllers\Contact;

use App\ContactType;
use App\Http\Resources\ContactType as ContactTypeResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    
    public function index()
    {
        return ContactTypeResource::collection(ContactType::all());
    }

    
    public function store(Request $request)
    {
        $contact = $request->only(['type']);
        $contact = ContactType::create($contact);
        return new ContactTypeResource($contact);
    }

    
    public function show($id)
    {
        return new ContactTypeResource(ContactType::find($id));
    }

    
    public function update(Request $request, $id)
    {
        $contactReq = $request->only(['type']);
        $contact = ContactType::find($id);
        $contact->update($contactReq);
        return new ContactTypeResource($contact);
    }

    
    public function destroy($id)
    {
        $contact = ContactType::destroy($id);
        if ($contact) {
            return response()->json([
                "data" => "deleted successfuly",
            ]);
        }
        return response()->json([
            "data" => "contact type doesn't exist",
        ]);
    }
}
