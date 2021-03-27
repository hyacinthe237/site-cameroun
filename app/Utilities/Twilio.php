<?php
namespace App\Utilities;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

/**
 * Twilio Send Message
 */
class Twilio
{
    /**
    * Send SMS for user after on booking
    */
    public static function sendBookingConfirmation ($booking)
    {
        $paylater = $booking->status === 'paylater' ? 'Please, do not forget to pay your booking.' : '';

        $body = "XMD Rentals booking confirmation. Booking ID: " .$booking->number
            . ". Pick up from " .$booking->location->name ." on "
            . $booking->getPickupDateAttribute() . "@" . $booking->getPickupTimeAmPm()
            . ". " . $paylater;

        self::sendSmsToNumber($booking->user->phone, $body);
    }

    /**
    * Send SMS for user after created Account
    */
    public static function sendVerificationCode ($user)
    {
        $body = "Dear " . ucwords($user->name)
            . ", Your verification code is: " . $user->verification_code . ".";

        self::sendSmsToNumber($user->phone, $body);
    }

    /**
     * [sendSmsToNumber description]
     * @param  [type] $number  [description]
     * @param  [type] $message [description]
     * @return [type]          [description]
     */
    private static function sendSmsToNumber ($number, $message)
    {
        $account_sid = config('services.twilio.sid');
        $auth_token = config('services.twilio.token');
        $twilio_number = config('services.twilio.number');
        $client = new Client($account_sid, $auth_token);

        $client->messages->create($number, [
            'from' => $twilio_number,
            'body' => $message
        ]);
    }
}
