<?php

namespace App\Http\Controllers\Admin;

use App\CompanySetting;
use App\Company;
use App\Helper\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanySettingsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.companySettings');
        $this->pageIcon = 'icon-settings';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(! $this->user->can('manage_settings'), 403);

        $this->timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $this->setting = CompanySetting::where('id',$this->user->company_id)->first();

        if(!$this->setting){
            abort(404);
        }

        return view('admin.settings.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(! $this->user->can('manage_settings'), 403);
        $this->user = auth()->user();
        $setting = CompanySetting::find($this->user->company_id);
        $setting->company_name = $request->input('company_name');
        $setting->company_email = $request->input('company_email');
        $setting->company_phone = $request->input('company_phone');
        $setting->website = $request->input('website');
        $setting->address = $request->input('address');
        $setting->timezone = $request->input('timezone');
        $setting->latitude = $request->input('latitude');
        $setting->longitude = $request->input('longitude');
        $setting->locale = $request->input('locale');

        $setting->side_bar_color = $request->input('side_bar_color');
        $setting->side_bar_text_color = $request->input('side_bar_text_color');

        if ($request->hasFile('logo')) {
            $setting->logo = $request->logo->hashName();
            $request->logo->store('user-uploads/company-logo');
        }

       // $companies = Company::find(1);
       // $companies->company_name = $request->input('company_name');
      //  $companies->company_email = $request->input('company_email');
      //  $companies->company_phone = $request->input('company_phone');
      //  $companies->website = $request->input('website');
     //   $companies->address = $request->input('address');
        // $companies->timezone = $request->input('timezone');
        // $companies->latitude = $request->input('latitude');
        //$companies->longitude = $request->input('longitude');
        //$companies->locale = $request->input('locale');

     //   if ($request->hasFile('logo')) {
      //       $setting->logo = $request->logo->hashName();
            //$companies->logo = $request->logo->hashName();
      //       $request->logo->store('user-uploads/app-logo');
      //   }

        $setting->save();
        //$companies->save();


        return Reply::redirect(route('admin.settings.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
