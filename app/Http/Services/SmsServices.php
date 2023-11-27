<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class SmsServices
{
    // public function sendSMS($to, $text, $from = null){
    //     try{

    //         if(get_setting('active_sms_gateway') == 'bulksmsbd'){

    //             Http::post('http://66.45.237.70/api.php', [
    //                 'username' => env('BULK_SMS_ID'),
    //                 'password' => env('BULK_SMS_PASSWORD'),
    //                 'number' => "$to",
    //                 'message' => "$text"
    //             ]);

    //         }elseif(get_setting('active_sms_gateway') == 'twilio'){
    //             $TWILIO_SID = env('TWILIO_SID');
    //             $TWILIO_AUTH_TOKEN = env('TWILIO_AUTH_TOKEN');

    //             Http::withHeaders([
    //                 'Authorization' => 'Basic ' . \base64_encode("$TWILIO_SID:$TWILIO_AUTH_TOKEN")
    //             ])->asForm()->post("https://api.twilio.com/2010-04-01/Accounts/$TWILIO_SID/Messages.json", [
    //                 "Body" => $text,
    //                 "From" => env('VALID_TWILLO_NUMBER'),
    //                 "To" => $to,
    //             ]);

    //         }elseif(get_setting('active_sms_gateway') == 'vonage'){
    //             Http::post('https://rest.nexmo.com/sms/json', [
    //                 'from' => env('APP_NAME'),
    //                 'text' => $text,
    //                 'to' => $to,
    //                 'api_key' => env('VONAGE_KEY'),
    //                 'api_secret' => env('VONAGE_SECRET'),
    //             ]);
    //         }
    //     }catch(Exception $e){
    //         // dd($e);
    //     }
    // }

    public function sendSMS($to, $text, $from = null){
        try{
            // dd($to, $text);
            if(get_setting('active_sms_gateway') == 'bulksmsbd'){
                Http::asForm()->post('https://bulksmsbd.net/api/smsapi', [
                    'senderid' => env('BULK_SMS_SENDER_ID'),
                    'api_key' => env('BULK_SMS_API_KEY'),
                    'number' => "$to",
                    'message' => "$text"
                ]);

            }elseif(get_setting('active_sms_gateway') == 'twilio'){
                $TWILIO_SID = env('TWILIO_SID');
                $TWILIO_AUTH_TOKEN = env('TWILIO_AUTH_TOKEN');

                Http::withHeaders([
                    'Authorization' => 'Basic ' . \base64_encode("$TWILIO_SID:$TWILIO_AUTH_TOKEN")
                ])->asForm()->post("https://api.twilio.com/2010-04-01/Accounts/$TWILIO_SID/Messages.json", [
                    "Body" => $text,
                    "From" => env('VALID_TWILLO_NUMBER'),
                    "To" => $to,
                ]);

            }elseif(get_setting('active_sms_gateway') == 'vonage'){
                Http::post('https://rest.nexmo.com/sms/json', [
                    'from' => env('APP_NAME'),
                    'text' => $text,
                    'to' => $to,
                    'api_key' => env('VONAGE_KEY'),
                    'api_secret' => env('VONAGE_SECRET'),
                ]);
            }
        }catch(Exception $e){
            // dd($e);
        }
    }
    public function phoneVerificationSms($to,$code){
        $sms = 'Your verification code for Ejab Distribution Limited is '.$code.'.';
        $this->sendSMS($to,$sms);
    }
    public function forgotPasswordSms($to,$code){
        $sms = 'Your password reset code for Ejab Distribution Limited is '.$code.'.';
        $this->sendSMS($to,$sms);
    }
    public function orderPlaceSms($to,$orderCode){
        $sms = 'Your Ejab Distribution Limited order has been placed and Order Code is : '.$orderCode.'.';
        $this->sendSMS($to,$sms);
    }
    public function orderPlaceAdminSms($to,$orderCode){
        $sms = 'Ejab Distribution Limited got a new order and Order Code is : '.$orderCode.'.';
        $this->sendSMS($to,$sms);
    }
    public function orderUpdateSms($to,$orderCode, $status){
        // $sms = 'Your Ejab Distribution Limited order('.$orderCode.') status has been updated to '.str_replace('_', ' ', $status).'.';
        $sms = 'Your "Ejab Distribution Limited" delivery status has been updated to '.$status.' for Fortune Order code: '.$orderCode.'';
        $this->sendSMS($to,$sms);
    }
}
