<?php
namespace App\Service;
use Twilio\Rest\Client;

class SmsService
{
    public function sendSms(string $destinationNumber, string $message): void
    {
        $sid    = TWILIO_SID;
        $token  = TWILIO_TOKEN;
        $twilio = new Client($sid, $token);

        if (substr($destinationNumber, 0, 4) !== '+221') {
            $destinationNumber = '+221' . ltrim($destinationNumber, '0');
        }

        try {
            $twilio->messages->create(
                $destinationNumber, 
                [
                    'from' => TWILIO_FROM,
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            // Optionnel : log l'erreur
        }
    }
}
