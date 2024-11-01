<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\TemplateFormRequest;
use App\Models\TemplateForm;
use App\Models\TemplateFormVanBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VanbanFormController extends Controller
{
    //

    // public function index(){
    //     $title = 'Form Văn bản';
    //     $templates =  TemplateForm::all();
    //     $templateActive =  TemplateForm::where('status',Status::ENABLE)->first();
    //     return view('admins.pages.form.vanban' , compact('title','templates','templateActive'));
    // }

    public function index(Request $request)
    {
        $inputs = $request->all();
        $template = TemplateFormVanBan::query();

        if (isset($request->name_form) && $request->name_form != '') {
            $template->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name_form . '%')
                    ->orWhere('template_form', 'like', '%' . $request->name_form . '%');
            });
        }

        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $template = $template->paginate($perPage);

        $title   = "Danh template form";
        return view("admins.pages.templateform_vanban.index", [
            "template" => $template,
            "title"  => $title,
            "inputs" => $inputs,

        ]);
    }

    public function create()
    {
        $title = "Tạo mới template form văn bản";
        return view("admins.pages.templateform_vanban.add", ["title" => $title]);
    }

    public function store(TemplateFormRequest $request)
    {
        $existingTemplate = TemplateFormVanBan::where('name', $request->name)->first();

        if ($existingTemplate) {
            return back()->withErrors(['name' => 'Tên template form này đã tồn tại.'])->withInput();
        }

        // dd($request->all());
        if ($request->status === 'active') {
            TemplateFormVanBan::where('status', 'active')->update(['status' => 'unactive']);
            // $bladeFilePath = resource_path('views/admins/pages/vanban/form-add.blade.php');
            // File::put($bladeFilePath, $request->template_form);
        }
        TemplateFormVanBan::create([
            'name' => $request->name,
            'template_form' => $request->template_form,
            'status' => $request->status == 'active' ? 'active' : 'unactive',
        ]);


        return back()->with('success', 'Template form đã được thêm thành công.');
    }

    public function edit($id)
    {
        $template = TemplateFormVanBan::find($id);
        // dd($template);
        if (!$template) {
            return redirect()->route('admin.templateform_vanban.index')->with('error', 'Không tìm thấy template form này.');
        }

        $title = "Sửa template form văn bản";
        return view("admins.pages.templateform_vanban.edit", ["title" => $title, "template" => $template]);
    }

    public function update(TemplateFormRequest $request, $id)
    {
        $templateForm = TemplateFormVanBan::findOrFail($id);

        $existingTemplate = TemplateFormVanBan::where('name', $request->name)
            ->where('id', '!=', $id)
            ->first();

        if ($existingTemplate) {
            return back()->withErrors(['name' => 'Tên template form này đã tồn tại.'])->withInput();
        }

        // if ($request->has('status')) {
        //     TemplateFormVanBan::where('status', 'active')
        //         ->where('id', '!=', $id)
        //         ->update(['status' => 'unactive']);
        //     $bladeFilePath = resource_path('views/admins/pages/vanban/form-add.blade.php');

        //     File::put($bladeFilePath, $request->template_form);
        // }

        if ($request->status === 'active') {
            TemplateFormVanBan::where('status', 'active')
                ->where('id', '!=', $id)
                ->update(['status' => 'unactive']);
            // $bladeFilePath = resource_path('views/admins/pages/vanban/form-add.blade.php');
            // File::put($bladeFilePath, $request->template_form);
        }

        $templateForm->update([
            'name' => $request->name,
            'template_form' => $request->template_form,
            'status' => $request->has('status') ? 'active' : 'unactive',
        ]);

        return back()->with('success', 'Template form đã được sửa thành công.');
    }
    public function destroy($id)
    {
        $template = TemplateFormVanBan::find($id);
        if (!$template) {
            return redirect()->route('admin.templateform_vanban.index')->with('error', 'Không tìm thấy template form này.');
        }

        $template->delete();
        return back()->with('success', 'Template form đã được xóa thành công.');
    }

    public function updatestatus(Request $request, $id)
    {
        $templateForm = TemplateFormVanBan::findOrFail($id);

        if ($request->has('status')) {
            TemplateFormVanBan::where('id', '!=', $id)->update(['status' => 'unactive']);

            $templateForm->status = 'active';
            // $bladeFilePath = resource_path('views/admins/pages/vanban/form-add.blade.php');

            // File::put($bladeFilePath, $templateForm->template_form);
        } else {

            $templateForm->status = 'unactive';
        }


        $templateForm->save();

        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật thành công.');
    }
}
