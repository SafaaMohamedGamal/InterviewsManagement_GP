<?php

namespace App\Http\Controllers\Contact;

use App\Contact;
use App\ContactType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends Controller
{
    
    public function index()
    {
        return ContactResource::collection(Contact::paginate());
    }

    
    public function store(ContactRequest $request)
    {
        $contact = $request->only(['data', 'seeker_id', 'contact_types_id']);
        $contact_type = ContactType::find($contact['contact_types_id']);
        $contact = new Contact([
            'data' => $contact['data'],
            'seeker_id' => $contact['seeker_id']
        ]);
        $contact->contactType()->associate($contact_type);
        $contact->save();
        return new ContactResource($contact);
    }

    
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    
    public function update(ContactRequest $request,Contact $contact)
    {
        $contactReq = $request->only(['data', 'seeker_id', 'contact_types_id']);
        $contact->update([
            'data' => isset($contactReq['data']) ? $contactReq['data'] : $contact['data'],
            'seeker_id' => isset($contactReq['seeker_id']) ? $contactReq['seeker_id'] : $contact['seeker_id'],
        ]);
        if(isset($contactReq['contact_types_id'])){
            $contact->contactType()->associate(ContactType::find($contactReq['contact_types_id']))->save();
        }
        return new ContactResource($contact);
    }


    public function destroy($id)
    {
        $contact = Contact::destroy($id);
        if ($contact) {
            return response()->json(["data" => "deleted successfuly"]);
        }
        return response()->json(["data" => "contact doesn't exist"]);
    }
}
