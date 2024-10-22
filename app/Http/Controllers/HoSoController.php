<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HoSoController extends Controller
{
    public function index(){
        $title = 'Form hồ sơ';
        return view('admins.pages.form.hoso' , compact('title'));
    }
}
