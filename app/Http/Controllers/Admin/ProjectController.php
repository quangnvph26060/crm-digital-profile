<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\KeywordImport;
use App\Models\Comment;
use App\Models\Keyword;
use App\Models\Mission;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function list()
    {
        $projects = Project::withCount(["missions" => function ($query) {
                                $query->where("missions.status", 5);
                            }])
                            ->withCount(["missions as total_mission"])
                            ->withCount(["missions as total_done" => function ($query) {
                                $query->where("missions.status", 1);
                            }])
                            ->withCount(["missions as total_edit" => function ($query) {
                                $query->where("missions.status", 2);
                            }])
                            ->withCount(["missions as total_wait_publish" => function ($query) {
                                $query->where("missions.status", 3);
                            }])
                            ->get();

        return view("admins.pages.projects.list", [
            "projects" => $projects
        ]);
    }

    public function export($id)
    {
        $project = Project::find($id);

        return \Excel::download(new \App\Exports\ExportPostPublished($project), 'url_publish.xlsx');
    }

    public function add()
    {
        return view("admins.pages.projects.add");
    }

    public function store(Request $request)
    {
        $checkExistProject = Project::where("name", $request->name)->first();

        if (!is_null($checkExistProject)) {
            return back()->withInput()->with("error", "Dự án đã trùng");
        }
        Project::create($request->except("_token"));

        return back()->with("success", "Thêm thành công");
    }

    public function getViewImport($id)
    {
        return view("admins.pages.projects.import", [
            "projectId" => $id
        ]);
    }

    public function storeHandle(Request $request, $id)
    {
        $datas = [];
        foreach (explode(",", $request->keyword) as $value) {
            $datas[] = [
                "project_id" => $id,
                "name" => $value,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ];
        }
        Keyword::insert($datas);

        return back()->with("success", "Thêm thành công");
    }

    public function storeImport(Request $request, $projectId)
    {
        Excel::import(new KeywordImport($projectId), $request->file('file_import'));

        return back()->with("success", "Import thành công");
    }

    public function getViewAddMission($projectId)
    {
        $users = User::all();
        $keywords = Keyword::where("project_id", $projectId)->get();
        return view("admins.pages.projects.add_mission", [
            "projectId" => $projectId,
            "users" => $users,
            "keywords" => $keywords
        ]);
    }

    public function storeMission(Request $request, $projectId)
    {
        try {
            DB::beginTransaction();
            $user = User::whereId($request->user_id)->first();
            $totalKeywordByDate = Mission::where("date", $request->date)
                                         ->where("user_id", $request->user_id)
                                         ->count();
            if (count($request->keyword) + $totalKeywordByDate > $user->post_number_per_day) {
                return back()->with("error", "Tổng số keyword bạn giao trong dự án này phải nhỏ hơn số bài viết được cài đặt cho mỗi User");
            }
            $datas = $comments = [];
            $checkExistKeyword = Mission::where("project_id", $projectId)
                                        ->where('user_id', $request->user_id)
                                        ->whereIn("keyword", $request->keyword)
                                        ->get();

            if (count($checkExistKeyword) > 0) {
                return back()->with("error", "Các từ khóa sau đã bị trùng khi giao cho user $user->full_name: " . implode(",", $checkExistKeyword->pluck("keyword")->toArray()));
            }
            foreach ($request->keyword as $keywordItem) {
                $datas[] = [
                    "project_id" => $projectId,
                    "keyword" => $keywordItem,
                    "user_id" => $request->user_id,
                    "date" => $request->date,
                    "deadline" => $request->deadline,
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
                ];
            }
            Mission::insert($datas);
            if ($request->message != '') {
                $missions = Mission::latest('id')->take(count($datas))->get();
                foreach ($missions as $item) {
                    $comments[] = [
                        "admin_id" => auth('admin')->user()->id,
                        "message" => $request->message,
                        "mission_id" => $item->id,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ];
                }
                Comment::insert($comments);
            }
            Keyword::whereIn("name", $request->keyword)->where("project_id", $projectId)->delete();
            DB::commit();

            return back()->with("success", "Thêm thành công");
        } catch (\Throwable $th) {
            return back()->with("error", "Vui lòng thử lại");
        }
    }

    public function edit($id)
    {
        $project = Project::find($id);

        return view("admins.pages.projects.edit", [
            "project" => $project
        ]);
    }

    public function update(Request $request, $id)
    {
        Project::whereId($id)->update($request->except("_token"));

        return redirect()->route('admin.project.list')->with("success", "Thêm thành công");
    }
}
