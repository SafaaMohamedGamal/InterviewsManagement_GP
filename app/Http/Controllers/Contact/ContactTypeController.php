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

    
    public function show(ContactType $contacttype)
    {
        return new ContactTypeResource($contacttype);
    }

    
    public function update(UpdateContactTypeRequest $request, ContactType $contacttype)
    {
        $contacttype->update($request->only(['type']));
        return new ContactTypeResource($contacttype);
    }

    
    public function destroy($contacttype)
    {
        if (ContactType::destroy($contacttype)) {
            return response()->json([
                "data" => "deleted successfuly",
            ]);
        }
        return response()->json([
            "data" => "contact type doesn't exist",
        ]);
    }
}
