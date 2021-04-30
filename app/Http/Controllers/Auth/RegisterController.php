<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\User;
use App\CompanySetting;
use App\RoleUser;

use App\ThemeSetting;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function showRegistrationForm()
    {
        // $stripe = Stripe::make('sk_test_51Iac4qAwycdZAiddeVZFq4YnJccuo2KEgITVFAIxpNMmSxDKjV12aKC0bQVyVF3h6h66lgDqWmyjr7vzL5iLzKIP00mZXCSReZ');
        // $plan = Stripe::plans()->create([
        //     'id'                    => 'monthly',
        //     'name'                  => 'Monthly Subscription',
        //     'amount'                => 29.00,
        //     'currency'              => 'USD',
        //     'interval'              => 'month',
        //     'statement_descriptor' => 'The Agile Coach Subs.',
        // ]);
        // return $allPlans = Stripe::invoices()->all(array("customer" => 'cus_JDj3mOdsw2WdT5'));
        // return $customer = $stripe->customers()->find('cus_JDj3mOdsw2WdT5');
        $setting = CompanySetting::first();
        $frontTheme = ThemeSetting::first();
        return view('auth.register', compact('setting', 'frontTheme'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $setting = new CompanySetting();
        $setting->company_name = $data['companyname'];
        $setting->company_email = $data['email'];
        $setting->website = $data['website'];
        $setting->no_of_employees = 10;
        $setting->first_time_login = 0;
        $setting->save();

        $company = new Company();
        $company->company_name = $data['companyname'];
        $company->company_email = $data['email'];
        $company->website = $data['website'];  
        $company->status = "active";
        $company->show_in_frontend = "true";
        $company->save();
        
        $stripe = Stripe::make('sk_test_51Iac4qAwycdZAiddeVZFq4YnJccuo2KEgITVFAIxpNMmSxDKjV12aKC0bQVyVF3h6h66lgDqWmyjr7vzL5iLzKIP00mZXCSReZ');
        $customer = $stripe->customers()->create([
            'email' => $data['email'],
            'description' => $data['name']
        ]);
        $customerID = $customer['id'];
        $usr =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'company_id' => $setting->id,
            'customer_id' => $customer['id'],
            'stripe_id' => $customer['id'],
            'package' => $data['package'],
            'trial_ends_at' => now()->addDays(7)
        ]);
        // if($data['package']=='free'){
        //     Stripe::subscriptions()->create($customerID, [
        //         'plan' => $data['package'],
        //     ]);
        // }
        $role =  RoleUser::create([
            'user_id' => $usr->id,
            'role_id' => 1
        ]);


        
        
        
        return $usr;
    }
}
