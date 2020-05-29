<?php

namespace App\Http\Controllers\Contact;

use App\User;
use App\Seeker;
use App\Contact;
use App\ContactType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Resources\Contact as ContactResource;
use App\Http\Requests\Contact\UpdateContactRequest;

class ContactController extends Controller
{

    public function index()
    {
        return ContactResource::collection(Contact::all());
    }


    public function store(ContactRequest $request)
    {
        $contact = $request->only(['contacts', 'data', 'seeker_id', 'contact_types_id']);
        $user = User::find($contact['seeker_id']);
        //  adding muliple contacts
        if (isset($contact['contacts'])) {
            foreach ($contact['contacts'] as $contact) {
                $new_contact = new Contact();
                $new_contact->contactType()->associate($contact['contact_types_id']);
                $new_contact->data = $contact['data'];
                $new_contact->seeker()->associate($user->userable->id);
                $new_contact->save();
            }
            return new ContactResource($new_contact);
        }

        //  adding one contact
        $contact_type = ContactType::find($contact['contact_types_id']);
        $new_contact = new Contact([
            'data' => $contact['data'],
        ]);
        $new_contact->seeker()->associate($user->userable->id);
        $new_contact->contactType()->associate($contact_type);
        $new_contact->save();
        return new ContactResource($new_contact);
    }


    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }


    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contactReq = $request->only(['data', 'seeker_id', 'contact_types_id']);
        $contact->update([
            'data' => isset($contactReq['data']) ? $contactReq['data'] : $contact['data'],
            'seeker_id' => isset($contactReq['seeker_id']) ? $contactReq['seeker_id'] : $contact['seeker_id'],
        ]);
        if (isset($contactReq['contact_types_id'])) {
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
