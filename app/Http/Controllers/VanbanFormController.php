<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\TemplateForm;
use Illuminate\Http\Request;

class VanbanFormController extends Controller
{
    //

    public function index(){
        $title = 'Form Văn bản';
        $templates =  TemplateForm::all();
        $templateActive =  TemplateForm::where('status',Status::ENABLE)->first();
        return view('admins.pages.form.vanban' , compact('title','templates','templateActive'));
    }
}
