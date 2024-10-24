<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\TemplateFormVanBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VanBanController extends Controller
{
    //
    public function indexTemplate(){
        $title = 'Form văn bản';
        $templates =  TemplateFormVanBan::all();
        $templateActive =  TemplateFormVanBan::where('status',Status::ENABLE)->first();
        return view('admins.pages.form.vanban' , compact('title','templates','templateActive'));
    }

    public function storeTemplate(Request $request){
        $findTemplate = TemplateFormVanBan::find($request->title_form);
        //  dd($findTemplate);
        if(!$findTemplate){
            return back()->with('error', 'Không tìm thấy bản ghi cần chỉnh sửa.');
        }
        $findTemplate->template_form = $request->content_form;
        $findTemplate->name = $findTemplate->name;
        $findTemplate->save();

         // Đường dẫn đến tệp Blade cần cập nhật
        $bladeFilePath = resource_path('views/admins/pages/vanban/form-add.blade.php');

         // Cập nhật nội dung tệp Blade
        File::put($bladeFilePath, $request->content_form);
        return back()->with('success', 'Chỉnh sửa thành công');
    }
}
