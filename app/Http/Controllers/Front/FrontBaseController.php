<?php

namespace App\Http\Controllers\Front;

use App\CompanySetting;
use App\Job;
use App\LanguageSetting;
use App\ThemeSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class FrontBaseController extends Controller
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[ $name ]);
    }

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        // Inject currently logged in user object into every view of user dashboard
        $urls = $_SERVER['REQUEST_URI'];
        $split_url = explode("/",$urls);

        if(count($split_url) == 4){

            $slug = $split_url[2];

            $company_id = Job::where('id',$slug)->first()->company_id;
            $this->global = CompanySetting::where('id',$company_id)->first();

        }elseif(count($split_url) == 3){

            if($split_url[1] == "openings"){
                $slug = $split_url[2];
                $this->global = CompanySetting::where('id',$slug)->first();
            }elseif($split_url[2] == "saveApplication"){
                $this->global = CompanySetting::first();
            }elseif($split_url[2] == "saveVideo"){
                $this->global = CompanySetting::first();
            }elseif($split_url[2] == "saveMCQs"){
                $this->global = CompanySetting::first();
            }else{
                $slug = $split_url[2];
                $company_id = Job::where('slug',$slug)->first()->company_id;
                $this->global = CompanySetting::where('id',$company_id)->first();
            }
        }else{
            $this->global = CompanySetting::first();
        }


//        $this->emailSetting = EmailNotificationSetting::all();
        $this->companyName = $this->global->company_name;

        $this->frontTheme = ThemeSetting::first();
        $this->languageSettings = LanguageSetting::where('status', 'enabled')->get();

        App::setLocale($this->global->locale);
        Carbon::setLocale($this->global->locale);
        setlocale(LC_TIME,$this->global->locale.'_'.strtoupper($this->global->locale));

    }
}
