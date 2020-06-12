<?php

namespace App\Http\Controllers\Auth;

use Config;
use Twilio\Rest\Client;
use App\Seeker;
use App\Traits\PhoneTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

// use Illuminate\Foundation\Auth\VerifiesEmails;
// use Illuminate\Auth\Events\Verified;

class RegisterController extends Controller
{
    use PhoneTrait;
    // use VerifiesEmails;
    public $successStatus = 200;

    private $userRebo;
    public function __construct(UserRepositoryInterface $userRebository)
    {
        $this->userRebo = $userRebository;
    }

    public function register(StoreSeekerRequest $request)
    {
        $user = $request->only(['name', 'email', 'password', 'phone']);
        $seeker = new Seeker;
        $seeker->phone=$user['phone'];
        $seeker->save();
        $user = $this->userRebo->store($user);
        $seeker->user()->save($user);
        $user->assignRole('seeker');

        /* u have to remove hashing from this line to use mobile verification  */
        $this->verifyPhone($seeker->phone);

        $user->sendApiEmailVerificationNotification();
        $resource = json_decode(json_encode(new UserResource($user)), true);
        $resource['verify_email'] = false;
        return $resource;
    }


    public function checkPhoneVerification(Request $request)
    {
        // send user phone or get it from database and use it
        $request->only(['phone','verifyToken']);
        $phone = str_replace(' ', '', $request['phone']);

        if ($this->isVerifiedPhone($phone, $request['verifyToken'])) {
            $user=current_user();
            Seeker::where('id', $user->userable_id)->update(['isVerified'=>true]);
            return response()->json('phone verified');
        } else {
            return response()->json(['error' => 'code invalid waitting for another code'], 410);
        }
    }
}
