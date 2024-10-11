<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MissionImport;
use App\Models\Comment;
use App\Models\LogMission;
use App\Models\Mission;
use App\Models\Notification;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MissionController extends Controller
{
    public function add()
    {
        $projects = Project::all();
        $users = User::all();

        return view('admins.pages.missions.add', [
            'users' => $users,
            'projects' => $projects
        ]);
    }

    public function edit(Request $request, $id)
    {
        $mission = Mission::find($id);
        $projects = Project::all();
        $users = User::all();

        return view('admins.pages.missions.edit', [
            'users' => $users,
            'mission' => $mission,
            'projects' => $projects,
            'url_pre' => $request->url_pre
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "user_id" => "required",
            "deadline" => "required|date",
            "file" => "nullable|mimes:xlsx"
        ]);
        try {
            if (!empty($request->file_import)) {
                Excel::import(new MissionImport($request->except("_token")), $request->file('file_import'));
            } else {
                DB::beginTransaction();
                $datas = $comments = [];
                foreach (explode(",", $request->keyword) as $keywordItem) {
                    $datas[] = [
                        "project_id" => $request->project_id,
                        "keyword" => $keywordItem,
                        "user_id" => $request->user_id,
                        "date" => date('Y-m-d'),
                        "deadline" => $request->deadline,
                        "deadline_edit" => empty($request->deadline_edit) ? NULL : $request->deadline_edit,
                        "deadline_publish" => empty($request->deadline_publish) ? NULL : $request->deadline_publish,
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
                DB::commit();
            }

            return back()->with('success', 'Thêm thành công');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Vui lòng thử lại');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "keyword" => "required",
            "user_id" => "required"
        ]);
        try {
            DB::beginTransaction();
            $mission = Mission::whereId($id)->first();
            if ($request->status == 2 || $request->status == 3) {
                $checkLogMission = LogMission::where("mission_id", $mission->id)
                                             ->whereMonth("date", date("m"))
                                             ->where("status", $request->status)
                                             ->first();
                if (is_null($checkLogMission)) {
                    LogMission::create([
                        "mission_id" => $mission->id,
                        "status" => $request->status,
                        "user_id" => $mission->user_id,
                        "date" => date("Y-m-d")
                    ]);
                } else {
                    $checkLogMission->update([
                        "date" => date("Y-m-d")
                    ]);
                }
            }
            $mission->update($request->except("_token", "message"));
            if (!empty($request->message)) {
                Comment::create([
                    "mission_id" => $id,
                    "user_id" => $mission->user_id,
                    "message" => $request->message
                ]);
                $notification = Notification::create([
                    "name" => "Có trao đổi trong từ khóa: <b>$mission->keyword</b>",
                    "user_id" => $mission->user_id,
                    "url" => route('customer.mission.list', ['mission_id' => $id, 'status' => $request->status]),
                    "status" => 0
                ]);
                Notification::whereId($notification->id)
                            ->update([
                                "url" => route('customer.mission.list', ['mission_id' => $id, 'status' => $request->status, "noti" => $notification->id]),
                            ]);
            }
            DB::commit();
            if (!empty($request->get("url_pre"))) {
                return redirect(base64_decode($request->get("url_pre")))->with("success", "Cập nhật thành công");
            }

            return redirect()->route('admin.mission.list')->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Vui lòng thử lại');
        }
    }

    public function list(Request $request)
    {
        $missions = Mission::query();
        if (isset($request->keyword) && $request->keyword != '') {
            $missions->where('keyword', 'like', '%' . $request->keyword . '%');
        }
        if (isset($request->status) && $request->status != -1) {
            $missions->where('status', $request->status);
        }
        if (isset($request->date_from)) {
            $missions->where('date', '>=', $request->date_from);
        }
        if (isset($request->date_to)) {
            $missions->where('date', '<=', $request->date_to);
        }
        if (isset($request->user_id) && $request->user_id != -1) {
            $missions->where('user_id', $request->user_id);
        }
        if (isset($request->project_id) && $request->project_id != -1) {
            $missions->where('project_id', $request->project_id);
        }
        if (isset($request->noti)) {
            Notification::whereId($request->noti)->update(["status" => 1]);
        }
        if (isset($request->type_user) && $request->type_user != -1) {
            $missions->whereHas('user', function ($query) use ($request) {
                $query->where("users.type", $request->type_user);
            });
        }

        return view("admins.pages.missions.list", [
            "missions" => $missions->latest()->paginate(20),
            "inputs" => $request->all(),
            "users" => User::all(),
            "projects" => Project::all()
        ]);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            Mission::whereId($id)->delete();
            LogMission::where("mission_id", $id)->delete();
            Comment::where("mission_id", $id)->delete();
            DB::commit();

            return back()->with('success', 'Xóa thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Vui lòng thử lại');
        }
    }

    public function comment($missionId)
    {
        $mission = Mission::find($missionId);
        $comments = Comment::where('mission_id', $missionId)
                           ->with(['admin', 'user'])
                           ->oldest()
                           ->get();

        return view("admins.pages.missions.comment", [
            "mission" => $mission,
            "comments" => $comments
        ]);
    }

    public function storeCommentOld(Request $request, $missionId)
    {
        try {
            $mission = Mission::find($missionId);
            DB::beginTransaction();
            Comment::create([
                "mission_id" => $missionId,
                "user_id" => NULL,
                "admin_id" => auth('admin')->user()->id,
                "message" => $request->message
            ]);
            $notification = Notification::create([
                "name" => "Có trao đổi trong từ khóa: <b>$mission->keyword</b>",
                "user_id" => $mission->user_id,
                "status" => 0
            ]);
            Notification::whereId($notification->id)
                        ->update([
                            "url" => route('customer.mission.list', ['mission_id' => $missionId, 'status' => $mission->status, 'noti' => $notification->id])
                        ]);
            DB::commit();

            return back()->with('success', 'Thành công');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Vui lòng thử lại');
        }
    }

    public function storeComment(Request $request)
    {
        try {
            $mission = Mission::find($request->mission_id);
            DB::beginTransaction();
            Comment::create([
                "mission_id" => $request->mission_id,
                "user_id" => NULL,
                "admin_id" => auth('admin')->user()->id,
                "message" => $request->message
            ]);
            $notification = Notification::create([
                "name" => "Có trao đổi trong từ khóa: <b>$mission->keyword</b>",
                "user_id" => $mission->user_id,
                "status" => 0
            ]);
            Notification::whereId($notification->id)
                        ->update([
                            "url" => route('customer.mission.list', ['mission_id' => $request->mission_id, 'status' => $mission->status, 'noti' => $notification->id])
                        ]);
            DB::commit();
            return response()->json([
                "success" => true,
                "data" => [
                    "message" => $request->message,
                    "sender_name" => auth('admin')->user()->full_name,
                    "is_user" => true,
                    "time" => date('H:i d/m/Y')
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "message" => "Vui lòng thử lại"
            ]);
        }
    }
}
