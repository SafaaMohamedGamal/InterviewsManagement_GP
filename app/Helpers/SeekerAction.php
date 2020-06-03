<?php

namespace App\Helpers;

use App\Contact;

class SeekerAction
{
  public static function update($req, $user)
  {
    $userSeeker = $user->userable;
    if (isset($req['contacts'])) {
      foreach ($req['contacts'] as $contact) {
        if (isset($contact['id'])) {
          $new_contact = Contact::find($contact['id']);
        }
        else {
          $new_contact = new Contact;
        }
        $new_contact->contact_types_id = $contact['contact_types_id'];
        $new_contact->data = $contact['data'];
        $new_contact->seeker()->associate($userSeeker);
        $new_contact->save();
      }
    }
    $status = $userSeeker->update(
      [
        'address' => isset($req["address"]) ? $req["address"] : $userSeeker->address,
        'city' => isset($req["city"]) ? $req["city"] : $userSeeker->city,
        'seniority' => isset($req["seniority"]) ? $req["seniority"] : $userSeeker->seniority,
        'expYears' => isset($req["expYears"]) ? $req["expYears"] : $userSeeker->expYears,
        'currentJob' => isset($req["currentJob"]) ? $req["currentJob"] : $userSeeker->currentJob,
        'currentSalary' => isset($req["currentSalary"]) ? $req["currentSalary"] : $userSeeker->currentSalary,
        'expectedSalary' => isset($req["expectedSalary"]) ? $req["expectedSalary"] : $userSeeker->expectedSalary,
        'phone' => isset($req["phone"]) ? $req["phone"] : $userSeeker->phone,
      ]
    );
    return $status;
  }
}
