<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function list()
    {
        $news = News::latest()->get();

        return view("admins.pages.news.list", [
            "news" => $news
        ]);
    }

    public function add()
    {
        return view("admins.pages.news.add");
    }

    public function edit($newsId)
    {
        $news = News::find($newsId);

        return view("admins.pages.news.edit", ["news" => $news]);
    }

    public function store(Request $request)
    {
        News::create($request->except("_token"));

        return back()->with("success", "Thêm thành công");
    }

    public function update(Request $request, $newsId)
    {
        News::whereId($newsId)->update($request->except("_token"));

        return redirect()->route("admin.news.list")->with("success", "Sửa thành công");
    }

    public function delete($newsId)
    {
        News::whereId($newsId)->delete();

        return back()->with("success", "Xóa thành công");
    }

    public function detail($newsId)
    {
        $news = News::find($newsId);

        return view("customers.pages.detail_news", [
            "news" => $news
        ]);
    }
}
