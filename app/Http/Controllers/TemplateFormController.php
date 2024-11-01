<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateFormRequest;
use App\Models\TemplateForm;
use Illuminate\Http\Request;

class TemplateFormController extends Controller
{
    //

    public function index(Request $request)
    {
        $inputs = $request->all();
        $template = TemplateForm::query();

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
        return view("admins.pages.templateform.index", [
            "template" => $template,
            "title"  => $title,
            "inputs" => $inputs,

        ]);
    }

    public function create()
    {
        $title = "Tạo mới template form văn bản";
        return view("admins.pages.templateform.add", ["title" => $title]);
    }

    public function store(TemplateFormRequest $request)
    {

        // Tạo mới template form
        TemplateForm::create([
            'name' => $request->name,
            'template_form' => $request->template_form,
            'status' => $request->has('status') ? 'active' : 'unactive',
        ]);

        return back()->with('success', 'Template form đã được thêm thành công.');
    }

    public function edit($id)
    {
        $template = TemplateForm::find($id);
        if (!$template) {
            return redirect()->route('admin.templateform.index')->with('error', 'Không tìm thấy template form này.');
        }

        $title = "Sửa template form v";
        return view("admins.pages.templateform.edit", ["title" => $title, "template" => $template]);
    }

    public function update(TemplateFormRequest $request, $id)
    {
        $templateForm = TemplateForm::find($id);

        // Cập nhật bản ghi
        $templateForm->update([
            'name' => $request->name,
            'template_form' => $request->template_form,
            'status' => $request->has('status') ? 'active' : 'unactive',
        ]);

        return back()->with('success', 'Template form đã được sửa thành công.');
    }
    public function destroy($id)
    {
        $template = TemplateForm::find($id);
        if (!$template) {
            return redirect()->route('admin.templateform.index')->with('error', 'Không tìm thấy template form này.');
        }

        $template->delete();
        return back()->with('success', 'Template form đã được xóa thành công.');
    }

    public function updatestatus(Request $request, $id)
    {
        $templateForm = TemplateForm::findOrFail($id);

        $templateForm->status = $request->has('status') ? 'active' : 'unactive';

        $templateForm->save();

        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật thành công.');
    }
}
