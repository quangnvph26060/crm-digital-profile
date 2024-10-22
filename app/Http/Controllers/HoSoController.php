<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\TemplateFormHoSo;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class HoSoController extends Controller
{
    public function indexTemplate(){
        $title = 'Form hồ sơ';
        $templates =  TemplateFormHoSo::all();
        $templateActive =  TemplateFormHoSo::where('status',Status::ENABLE)->first();
        return view('admins.pages.form.hoso' , compact('title','templates','templateActive'));
    }

    public function storeTemplate(Request $request){
        $findTemplate = TemplateFormHoSo::find($request->title_form);
        if(!$findTemplate){
            return back()->with('error', 'Không tìm thấy bản ghi cần chỉnh sửa.');
        }
        $findTemplate->template_form = $request->content_form;
        $findTemplate->name = $findTemplate->name;
        $findTemplate->save();

         // Đường dẫn đến tệp Blade cần cập nhật
        $bladeFilePath = resource_path('views/admins/pages/profiles/form-add.blade.php');

         // Cập nhật nội dung tệp Blade
        File::put($bladeFilePath, $request->content_form);
        return back()->with('success', 'Chỉnh sửa thành công');
    }
}
