<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use App\Seeker;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;

class SeekerRepository implements UserRepositoryInterface
{
   public function __construct(UserRepositoryInterface $userRebo)
   {
      $this->userRebo = $userRebo;
   }
    public function getAll()
    {}

    public function get()
    {}

    public function update($request, $seeker)
    {
        $inputs = $request->only([
            'address',
            'city',
            'seniority',
            'expYears',
            'currentJob',
            'currentSalary',
            'expectedSalary',
            'phone',
            'contacts'
        ]);
        $userSeeker = $seeker->userable;
            if (isset($inputs['contacts'])) {
                foreach ($inputs['contacts'] as $contact) {
                    if (isset($contact['id'])) {
                        $new_contact = Contact::find($contact['id']);
                    } else {
                        $new_contact = new Contact;
                    }
                    $new_contact->contact_types_id = $contact['contact_types_id'];
                    $new_contact->data = $contact['data'];
                    $new_contact->seeker()->associate($userSeeker);
                    $new_contact->save();
                }
            }

            $verified = true ;
            if (isset($inputs["phone"]) && $inputs["phone"] != $userSeeker->phone) {
                self::verifyPhone($inputs["phone"]);
                $verified=false ;
            }

            $status = $userSeeker->update(
                [
                  'address' => isset($inputs["address"]) ? $inputs["address"] : $userSeeker->address,
                  'city' => isset($inputs["city"]) ? $inputs["city"] : $userSeeker->city,
                  'seniority' => isset($inputs["seniority"]) ? $inputs["seniority"] : $userSeeker->seniority,
                  'expYears' => isset($inputs["expYears"]) ? $inputs["expYears"] : $userSeeker->expYears,
                  'currentJob' => isset($inputs["currentJob"]) ? $inputs["currentJob"] : $userSeeker->currentJob,
                  'currentSalary' => isset($inputs["currentSalary"]) ? $inputs["currentSalary"] : $userSeeker->currentSalary,
                  'expectedSalary' => isset($inputs["expectedSalary"]) ? $inputs["expectedSalary"] : $userSeeker->expectedSalary,
                  'phone' => isset($inputs["phone"]) ? $inputs["phone"] : $userSeeker->phone,
                  'isVerified' => $verified
                ]
            );
            return $userSeeker;
    }

    public function store($request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $seekerDetails = $request->only([
            'address',
            'city',
            'seniority',
            'expYears',
            'currentJob',
            'currentSalary',
            'expectedSalary',
            'phone',
            'contacts'
        ]);
        $userSeeker = $this->userRebo->store($user);
        $seeker = Seeker::create($seekerDetails);
        $seeker->user()->save($userSeeker);
        $seeker->save();
        $userSeeker->assignRole('seeker');
        if (isset($seekerDetails["contacts"])) {
            foreach ($seekerDetails['contacts'] as $contact) {
                $new_contact = new Contact;
                $new_contact->contact_types_id = $contact['contact_types_id'];
                $new_contact->data = $contact['data'];
                $new_contact->seeker()->associate($seeker);
                $new_contact->save();
            }
        }
        return $seeker;
    }


    public function uploadCV($request, $seeker)
    {
        $req = $request->only(['cv']);
        $path = '';
        $userSeeker = $seeker->userable;
        if (isset($req['cv'])) {
            $cvName = time() . '_' . $req['cv']->getClientOriginalName();
            $path = $req['cv']->storeAs(
                'public/cvs',
                $cvName
            );
            if ($userSeeker['cv']) {
                Storage::delete('public/cvs/' . $userSeeker->cv);
            }
        }
        $status = $userSeeker->update([
            'cv' => isset($req["cv"]) ? $cvName : $userSeeker->cv,
        ]);
        return $userSeeker;
    }
}
