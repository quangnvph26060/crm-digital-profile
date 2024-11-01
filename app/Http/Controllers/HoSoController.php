<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\TemplateFormRequest;
use App\Models\Profile;
use App\Models\TemplateFormHoSo;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class HoSoController extends Controller
{
   
    public function showTemplate(Request $request)
    {
        $inputs = $request->all();
        $template = TemplateFormHoSo::query();

        if (isset($request->name_form) && $request->name_form != '') {
            $template->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name_form . '%')
                    ->orWhere('template_form', 'like', '%' . $request->name_form . '%');
            });
        }

        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $template = $template->paginate($perPage);

        $title   = "Danh sách template hồ sơ";
        return view("admins.pages.templateform_hoso.index", [
            "template" => $template,
            "title"  => $title,
            "inputs" => $inputs,

        ]);
    }

    public function showAddFormHoSo()
    {
        $title = "Tạo mới template form";
        return view("admins.pages.templateform_hoso.add", ["title" => $title]);
    }

    public function store(TemplateFormRequest $request)
    {


        $existingTemplate = TemplateFormHoSo::where('name', $request->name)->first();

        if ($existingTemplate) {
            return back()->withErrors(['name' => 'Tên template form này đã tồn tại.'])->withInput();
        }
        $flag = true;
        if ($request->status == Status::ENABLE) {
            TemplateFormHoSo::where('status', 'active')->update(['status' => 'unactive']);
            $bladeFilePath = resource_path('views/admins/pages/profiles/form-add.blade.php');
            $flag = false;
            File::put($bladeFilePath, $request->template_form);
        }
        if (!$flag) {
            $is_active = 'active';
        } else {
            $is_active = 'unactive';
        }
        TemplateFormHoSo::create([
            'name' => $request->name,
            'template_form' => $request->template_form,
            'status' => $is_active,
        ]);
        return back()->with('success', 'Template form đã được thêm thành công.');
    }

    public function indexTemplate()
    {
        $title = 'Form hồ sơ';
        $templates =  TemplateFormHoSo::all();
        $templateActive =  TemplateFormHoSo::where('status', Status::ENABLE)->first();
        return view('admins.pages.form.hoso', compact('title', 'templates', 'templateActive'));
    }

    public function storeTemplate(Request $request)
    {
        $findTemplate = TemplateFormHoSo::find($request->title_form);
        if (!$findTemplate) {
            return back()->with('error', 'Không tìm thấy bản ghi cần chỉnh sửa.');
        }
        $findTemplate->template_form = $request->content_form;
        $findTemplate->name = $findTemplate->name;
        $findTemplate->save();

        // Đường dẫn đến tệp Blade cần cập nhật
      //  $bladeFilePath = resource_path('views/admins/pages/profiles/form-add.blade.php');

        // Cập nhật nội dung tệp Blade
     //   File::put($bladeFilePath, $request->content_form);
        return back()->with('success', 'Chỉnh sửa thành công');
    }

    // public function updatestatus(Request $request, $id)
    // {
    //     $templateForm = TemplateFormHoSo::findOrFail($id);

    //     if ($request->has('status')) {
    //         TemplateFormHoSo::where('id', '!=', $id)->update(['status' => 'unactive']);

    //         $templateForm->status = 'active';
    //         $bladeFilePath = resource_path('views/admins/pages/profiles/form-add.blade.php');

    //         File::put($bladeFilePath, $templateForm->template_form);
    //     } else {

    //         $templateForm->status = 'unactive';
    //     }


    //     $templateForm->save();

    //     return redirect()->back()->with('success', 'Trạng thái đã được cập nhật thành công.');
    // }
    public function updateStatus(Request $request, $id)
    {
        $templateForm = TemplateFormHoSo::findOrFail($id);

        if ($request->has('status')) {
            TemplateFormHoSo::where('id', '!=', $id)->update(['status' => 'inactive']);

            $templateForm->status = 'active';
        } else {
            $templateForm->status = 'inactive';
        }

        $templateForm->save();

        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $template = TemplateFormHoSo::find($id);
        if (!$template) {
            return redirect()->route('admin.profile.showTemplate')->with('error', 'Không tìm thấy template form này.');
        }
        if ($template->status === Status::ENABLE) {
            return redirect()->route('admin.profile.showTemplate')->with('error', 'Không tìm thấy template form này.');
        }
        $template->delete();
        return back()->with('success', 'Template form đã được xóa thành công.');
    }

    public function editHoSo($id)
    {
        $template = TemplateFormHoSo::find($id);
        // dd($template);
        if (!$template) {
            return redirect()->route('admin.templateform_hoso.index')->with('error', 'Không tìm thấy template form này.');
        }

        $title = "Sửa template form";
        return view("admins.pages.templateform_hoso.edit", ["title" => $title, "template" => $template]);
    }

    public function updateHoSo(Request $request, $id)
    {
        //  dd($request->all());
        $templateForm = TemplateFormHoSo::findOrFail($id);

        $existingTemplate = TemplateFormHoSo::where('name', $request->name)
            ->where('id', '!=', $id)
            ->first();

        if ($existingTemplate) {
            return back()->withErrors(['name' => 'Tên template form này đã tồn tại.'])->withInput();
        }

        $flag = true;
        if ($request->status == Status::ENABLE) {
            TemplateFormHoSo::where('status', 'active')->update(['status' => 'unactive']);
            $bladeFilePath = resource_path('views/admins/pages/profiles/form-add.blade.php');
            $flag = false;
            File::put($bladeFilePath, $request->template_form);
        }
        if (!$flag) {
            $is_active = 'active';
        } else {
            $is_active = 'unactive';
        }
        $templateForm->update([
            'name' => $request->name,
            'template_form' => $request->template_form,
            'status' => $is_active,
        ]);
        return back()->with('success', 'Template form đã được sửa thành công.');
    }
}
