<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Api\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function freeTrialExpired(Request $request){
        if($request->user()->trial_ends_at){
            return view('admin.dashboard.free-trial-finished');
        }
        abort('404');
    }

    public function changePlan(Request $request){
        $user =  $request->user();
        $plan = $request->plan;
        $subscription = Stripe::subscriptions()->update($user->stripe_id, $user->subscription_id, [
            'plan' => $plan,
        ]);
        $user->package = $plan;
        $user->update();
        return 'done';
    }

    public function cancelPlan(Request $request){
        $user =  $request->user();
        $subscription = Stripe::subscriptions()->cancel($user->stripe_id, $user->subscription_id,true);
        $user->ends_at = date('Y-m-d H:i:s', $subscription['current_period_end']);;
        $user->update();
        return 'done';
    }

    public function resubscribePlan(Request $request){
        $user =  $request->user();
        $subscription = Stripe::subscriptions()->reactivate($user->stripe_id, $user->subscription_id);
        if($user->ends_at){
            $user->ends_at=null;
            $user->update();
        }
        Session::flash('success','Congratulations');
        return 'done';
    }

    public function index(){
        return view('admin.dashboard.pay');
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
     * create customer
     */

 
    /**
     * add payment method with card
     */
    public function addCard(Request $request){
            $token = $request->cc_token;
            $package = $request->package;
            // creating customer
            $customer = Stripe::customers()->create([
                'email' => $request->user()->email,
            ]);
            $stripeCustomerId = $customer['id'];


            if($token) {
                // add card for the respective stripe customer
                $card = Stripe::cards()->create($stripeCustomerId, $token);
                // Log::debug($card);


                if ($card) {
                    // add subscription to the plan if card exist
                   $subscriptionId = $this->addSubscription($stripeCustomerId, $request->package);

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
                $user = $request->user();
                $user->stripe_id = $stripeCustomerId;
                $user->subscription_id = $subscriptionId;
                $user->package = $package;
                $user->card_brand = $request->brand;
                $user->card_last_four = $request->last4;
                $user->card_id = $request->cardId;
                if($user->trial_ends_at){
                    $user->trial_ends_at = null;
                }
                $user->update();
                return response()->json([
                    'success' => true,
                    'data' => $card,
                    'message' => 'Successfully setup payment information'
                ], 200);
            }
    } 

    // adding subscription to the any plan
    public function addSubscription($customerId, $plan) {
        $subscription = Stripe::subscriptions()->create($customerId, [
            'plan' => $plan,
        ]);


        return $subscription['id'];
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
    // creating premium plan
    public function createFreePlan(){
        $plan = Stripe::plans()->create([
            'id'                    => 'free',
            'name'                  => 'Free Plan',
            'amount'                => 0.00,
            'currency'              => 'USD',
            'interval'              => 'month',
            'statement_descriptor'  => 'The Hireworks Subs.',
        ]);
    }
    // executing both plan for the first time
    public function createPlan() {
        $this->createPlusPlan();
        $this->createPremiumPlan();
        $this->createFreePlan();
        // $this->createEnterprisePlan();
        return 'done';
    }
}