<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Api\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function upgrade(){
           $subscription = Stripe::subscriptions()->update($this->customerId, $this->subscription['id'], [
            'plan' => 'premium',
        ]);
    }
    public function test() {
//        $this->addCard();
//        $this->addSubscription('cus_JCKkDen88LosGG', 'annual');
//        $stripeUser = Stripe::customers()->create(array(
//            "description" => "test@gmail.com",
//            "email" => "test@gmail.com"
//        ));

//        dd($stripeUser['id']);

    }

 
    /**
     * add payment method with card
     */
    public function addCard(Request $request){
        $stripeCustomerId = $request->stripe_id;

        // return $request;
        // Log::debug($request->all());

        try {
            $token = Stripe::tokens()->create(array(
                "card" => array(
                    "number" => $request->number,
                    "exp_month" => $request->mm,
                    "exp_year" => $request->yy,
                    "cvc" => $request->cvc
                )
            ));

            if($token) {
                // add card for the respective stripe customer
                $card = Stripe::cards()->create($stripeCustomerId, $token['id']);
                // Log::debug($card);


                if ($card) {
                    // add subscription to the plan if card exist
                    $this->addSubscription($stripeCustomerId, $request->package);
                }

                // to get all invoices
                $allPlans = Stripe::invoices()->all(array("customer" => $stripeCustomerId));
                // if an invoice is due
                if(isset($allPlans['data'][0]['paid']) && !$allPlans['data'][0]['paid']) {
                    if($allPlans->data[0]->amount_due == 0) {
                        // if first invoice is due pay it
                        $invoice = Stripe::invoices()->pay($allPlans['data'][0]['id']);
                    }
                }
                return redirect('/admin/dashboard')->with('success','Plan activated');

                return response()->json([
                    'success' => true,
                    'data' => $card,
                    'message' => 'Successfully setup payment information'
                ], 200);
            }
        } catch (\Exception $e){
            return response()->json([
                'success' => true,
                'message' => 'Your card information is incorrect.'
            ], 404);
        }
    }

    // adding subscription to the any plan
    public function addSubscription($customerId, $plan) {
        $subscription = Stripe::subscriptions()->create($customerId, [
            'plan' => $plan,
        ]);


        return $subscription;
    }

    // creating plus plan
    public function createPlusPlan(){
        $plan = Stripe::plans()->create([
            'id'                    => 'plus',
            'name'                  => 'Plus Plan',
            'amount'                => 29.00,
            'currency'              => 'USD',
            'interval'              => 'month',
            'statement_descriptor' => 'The Hireworks Subs.',
        ]);
    }

    // creating premium plan
    public function createPremiumPlan(){
        $plan = Stripe::plans()->create([
            'id'                    => 'premium',
            'name'                  => 'Premium Plan',
            'amount'                => 79.00,
            'currency'              => 'USD',
            'interval'              => 'month',
            'statement_descriptor'  => 'The Hireworks Subs.',
        ]);
    }


    // creating enterprise plan
    // public function createEnterprisePlan(){
    //     $plan = Stripe::plans()->create([
    //         'id'                    => 'enterprise',
    //         'name'                  => 'Enterprise Plan',
    //         'amount'                => 79.00,
    //         'currency'              => 'USD',
    //         'interval'              => 'month',
    //         'statement_descriptor'  => 'The Hireworks Subs.',
    //     ]);
    // }

    // executing both plan for the first time
    public function createPlan() {
        $this->createPlusPlan();
        $this->createPremiumPlan();
        return 'done';
        // $this->createEnterprisePlan();
    }
}