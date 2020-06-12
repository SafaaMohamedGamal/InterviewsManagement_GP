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
use App\Http\Requests\Seeker\uploadCvRequest;

class SeekerController extends Controller
{
    private $userRebo;
    public function __construct(UserRepositoryInterface $userRebository)
    {
        $this->userRebo = $userRebository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny');
        $userSeeker = Seeker::simplePaginate($request->perPage?$request->perPage:15);
        return SeekerResource::collection($userSeeker);
    }

    public function store(StoreSeekerRequest $request)
    {
        $this->authorize('create');
        $userSeeker = $this->userRebo->store($request);
        return new SeekerResource($userSeeker);
    }

    public function show(User $seeker)
    {
        $this->authorize('view', $seeker->userable_type === 'App\Seeker' ? $seeker->userable : null);
        return new SeekerResource($seeker->userable);
    }

    public function update(UpdateSeekerRequest $request, User $seeker)
    {
        $this->authorize('update', $seeker->userable_type === 'App\Seeker' ? $seeker->userable : null);
        $seekerUpdated = $this->userRebo->update($request, $seeker);
        return new SeekerResource($seekerUpdated);
    }

    public function destroy(User $seeker)
    {
        $this->authorize('delete', $seeker->userable_type === 'App\Seeker' ? $seeker->userable : null);
        $seeker->userable->delete();
        return ['data' => true];
    }

    public function uploadCV(uploadCvRequest $request, User $seeker)
    {
        $userSeeker = $this->userRebo->uploadCV($request, $seeker);
        return new SeekerResource($userSeeker);
    }

    public function downloadCV(Request $request)
    {
        $cvName = $request->cvName;
        $url = Storage::download('public/cvs/' . $cvName);
        return $url;
    }
}
