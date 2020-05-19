<?php

namespace App\Http\Controllers\Contact;

use App\ContactType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactTypeRequest;
use App\Http\Requests\Contact\UpdateContactTypeRequest;
use App\Http\Resources\ContactType as ContactTypeResource;

class ContactTypeController extends Controller
{
    
    public function index()
    {
        return ContactTypeResource::collection(ContactType::all());
    }

    
    public function store(StoreContactTypeRequest $request)
    {
        return new ContactTypeResource(ContactType::create($request->only(['type'])));
    }

    
    public function show(ContactType $contact_type)
    {
        return new ContactTypeResource($contact_type);
    }

    
    public function update(UpdateContactTypeRequest $request, ContactType $contact_type)
    {
        $contact_type->update($request->only(['type']));
        return new ContactTypeResource($contact_type);
    }

    
    public function destroy($id)
    {
        if (ContactType::destroy($id)) {
            return response()->json([
                "data" => "deleted successfuly",
            ]);
        }
        return response()->json([
            "data" => "contact type doesn't exist",
        ]);
    }
}
