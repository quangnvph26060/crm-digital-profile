<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VanbanFormController extends Controller
{
    //

    public function index(){
        $title = 'Form Văn bản';
        return view('admins.pages.form.vanban' , compact('title'));
    }
}
