<?php

namespace App\Http\Controllers\Auth;

use App\Seeker;
use Twilio\Rest\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Seeker as SeekerResource;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $seeker = new Seeker;
        $seeker->phone=$request['phone'];
        $seeker->save();
        $user = \App\Helpers\UserAction::store($user);
        $seeker->user()->save($user);
        $user->assignRole('seeker');

        $this->verifyPhone($seeker->phone);

        
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
        $twilio = $this->getTwilioClient();
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($request['verifyToken'], array('to' => $request['phone']));
        if ($verification->valid) {
            $user=current_user();
            Seeker::where('id', $user->userable_id)->update(['isVerified'=>true]);
            // Seeker::where('phone', $request['phone'])->update(['isVerified'=>true]);
            return response()->json('phone verified');
        } else {
            return response()->json('error happend');
        }
    }

    private function getTwilioClient()
    {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        return new Client($twilio_sid, $token);
    }
}
