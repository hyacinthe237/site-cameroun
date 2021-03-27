<?php
namespace App\Utilities;
use Cartalyst\Stripe\Stripe;

class StripeService
{
    public $stripe;

    public function __construct ()
    {
        $secret = config('services.stripe.secret');
        $version = config('services.stripe.version');
        $this->stripe = Stripe::make($secret, $version);
    }

    /**
     * Create a new customer in Stripe
     * @param  App\Models\User $user
     * @param  String $token
     * @return Stripe::Customer
     */
    public function createCustomer ($user, $token)
    {
        return $this->stripe->customers()->create([
            'email'  => $user->email,
            'source' => $token,
            'metadata' => [
                'firstname' => $user ? $user->firstname : 'Uknown',
                'lastname'  => $user ? $user->lastname : 'Uknown User',
                'email'     => $user ? $user->email : 'No email',
                'mobile'    => $user ? $user->mobile : 'No mobile'
            ]
        ]);
    }

    /**
     * Charge an existing customer
     *
     * @param  String $customerID
     * @param  Integer $amountInCents
     * @param  String $description
     * @return Stripe::Charge
     */
    public function chargeCustomer ($customerID, $amountInCents, $description, $charge = true)
    {
        return $this->stripe->charges()->create([
            'currency' => 'aud',
            'customer' => $customerID,
            'amount'   => $amountInCents / 100,
            'description' => $description,
            'capture' => $charge
        ]);
    }

    /**
     * Direct charge to a user
     *
     * @param  App\Models\User $user
     * @param  String $token
     * @param  Integer $amountInCents
     * @param  String
     * @return Stripe::Charge
     */
    public function chargeUser ($user, $token, $amountInCents, $description)
    {
        return $this->stripe->charges()->create([
            'currency' => 'aud',
            'amount'   => $amountInCents / 100,
            'description' => $description,
            'metadata' => [
                'firstname' => $user ? $user->firstname : 'Uknown',
                'lastname'  => $user ? $user->lastname : 'Uknown User',
                'email'     => $user ? $user->email : 'No email',
                'mobile'    => $user ? $user->mobile : 'No mobile'
            ]
        ]);
    }
}
