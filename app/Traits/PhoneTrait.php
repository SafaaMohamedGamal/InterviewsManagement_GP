<?php
namespace App\Traits;

use Config;
use Twilio\Rest\Client;

/**
 *
 */
trait PhoneTrait
{
    public function verifyPhone($phone)
    {
        $twilio = $this->getTwilioClient();
        $twilio_verify_sid=config('twilio.TWILIO_VERIFY_SID');
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($phone, "sms");
    }

    public function getTwilioClient()
    {
        $token = config('twilio.TWILIO_AUTH_TOKEN');
        $twilio_sid = config('twilio.TWILIO_SID');
        return new Client($twilio_sid, $token);
    }

    public function isVerifiedPhone($phone, $code)
    {
        $twilio =$this->getTwilioClient();
        $twilio_verify_sid=config('twilio.TWILIO_VERIFY_SID');

        try {
            /*remove hash */
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($code, array('to' => $phone));
            if ($verification->valid) {
                return true ;
            } else {
                $this->verifyPhone($phone);
                return false ;
            }
        } catch (\Throwable $th) {
            /* remove hash */
            $this->verifyPhone($phone);
            return false ;
        }
    }
}
