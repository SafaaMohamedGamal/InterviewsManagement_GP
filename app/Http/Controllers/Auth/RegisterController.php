<?php

namespace App\Http\Controllers\Auth;

use App\Seeker;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Resources\Seeker as SeekerResource;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

class RegisterController extends Controller
{
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
        // $this->verifyPhone($seeker->phone);


        return new SeekerResource($user);
    }

    private function verifyPhone($phone)
    {
        $twilio = $this->getTwilioClient();
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($phone, "sms");
    }

    public function checkPhoneVerification(Request $request)
    {
        // send user phone or get it from database and use it
        $request->only(['phone','verifyToken']);
        $phone = str_replace(' ', '', $request['phone']);

        $twilio = $this->getTwilioClient();
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        try {
            /*  hash */
            throw new Exception("Error Processing Request", 1);

            /*remove hash */
            /*$verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($request['verifyToken'], array('to' => $phone));
            if ($verification->valid) {
                $user=current_user();
                Seeker::where('id', $user->userable_id)->update(['isVerified'=>true]);
            return response()->json('phone verified');
            } else {
            $this->verifyPhone($phone);
                return response()->json(['error' => 'code invalid waitting for another code'], 410);
            }*/
        } catch (\Throwable $th) {
            /* remove hash */
            // $this->verifyPhone($phone);
            return response()->json(['error' => 'code invalid waitting for another code'], 410);
        }
    }

    private function getTwilioClient()
    {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        return new Client($twilio_sid, $token);
    }
}
