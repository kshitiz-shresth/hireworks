<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentSettingController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Payment Data';
        $this->pageIcon = 'icon-settings';
    }
    public function index(){

        return view('admin.payment-settings.index',$this->data);
    }
}
