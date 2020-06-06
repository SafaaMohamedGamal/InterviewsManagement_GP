<?php

namespace App\Http\Controllers;

use App\User;
use App\Seeker;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Resources\SeekerResource;
use App\Http\Requests\Seeker\UpdateSeekerRequest;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

class SeekerController extends Controller
{
    private $userRebo;
    public function __construct(UserRepositoryInterface $userRebository)
    {
        $this->userRebo = $userRebository;
    }

    public function index()
    {
        $this->authorize('viewAny');
        $userSeeker = Seeker::simplePaginate(request()->perPage);
        return SeekerResource::collection($userSeeker);
    }

    public function store(StoreSeekerRequest $request)
    {
        $this->authorize('create');
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
        return new SeekerResource($userSeeker->userable);
    }

    public function show(User $seeker)
    {
        $this->authorize('view', $seeker->userable_type === 'App\Seeker' ? $seeker->userable : null);
        return new SeekerResource($seeker->userable);
    }

    public function update(UpdateSeekerRequest $request, User $seeker)
    {
        $this->authorize('update', $seeker->userable_type === 'App\Seeker' ? $seeker->userable : null);
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
        // return $inputs;
        $status = \App\Helpers\SeekerAction::update($inputs, $seeker);

        return new SeekerResource($seeker->userable);
    }

    public function destroy(User $seeker)
    {
        $this->authorize('delete', $seeker->userable_type === 'App\Seeker' ? $seeker->userable : null);
        $userSeeker = $seeker->userable;
        $userSeeker->user()->delete();
        $userSeeker->delete();
        return ['data' => true];
    }

    public function uploadCV(Request $request, User $seeker)
    {
        $request->validate([
            'cv' => 'required|mimetypes:application/pdf|max:10000',
        ]);
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
                Storage::delete($userSeeker->cv);
            }
        }
        $status = $userSeeker->update([
            'cv' => isset($req["cv"]) ? $cvName : $userSeeker->cv,
        ]);
        return new SeekerResource($seeker);
    }

    public function downloadCV(Request $request, User $seeker)
    {
        $cvName = $request->cvName;
        $url = Storage::download('public/cvs/'.$cvName);
        return $url;
    }
}
