<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\TemplateFormHoSo;
use Illuminate\Http\Request;

class HoSoController extends Controller
{
    public function index(){
        $title = 'Form hồ sơ';
        $templates =  TemplateFormHoSo::all();
        $templateActive =  TemplateFormHoSo::where('status',Status::ENABLE)->first();
        return view('admins.pages.form.hoso' , compact('title','templates','templateActive'));
    }
}
