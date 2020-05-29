<?php

namespace App\Http\Controllers;

use App\User;
use App\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Resources\Seeker as SeekerResource;
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
        $userSeeker = User::all()
            ->where('userable_type', 'App\Seeker');
        return SeekerResource::collection($userSeeker);
    }

    public function store(StoreSeekerRequest $request)
    {
        $this->authorize('create');
        $user = $request->only(['name', 'email', 'password']);
        $userSeeker = $this->userRebo->store($user);
        $seeker = Seeker::create();
        $seeker->user()->save($userSeeker);
        $userSeeker->assignRole('seeker');
        return new SeekerResource($userSeeker);
    }

    public function show(User $seeker)
    {
        $this->authorize('view', $seeker->userable_type === 'App\Seeker' ? $seeker->userable : null);
        return new SeekerResource($seeker);
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
        return new SeekerResource($seeker);
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
            'cv' => 'required|file',
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

        // return $status;
        return new SeekerResource($seeker);
    }

    public function downloadCV(Request $request, User $seeker){
        $cvName = $request->cvName;
        $url = Storage::download('public/cvs/'.$cvName);
        return $url;
    }

}
