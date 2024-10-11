<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\LogMission;
use App\Models\Mission;
use App\Models\Notification;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MissionController extends Controller
{
    public function getListMission(Request $request)
    {
        $inputs = $request->all();

        if (count($inputs) == 0) {
            $inputs['status'] = 0;
        }
        $missions = Mission::query();
        $missions->where('user_id', auth()->user()->id)
                 ->where("date", "<=", date("Y-m-d"))
                 ->latest();
        if (isset($inputs['mission_id'])) {
            $missions->whereId($inputs['mission_id']);
        }
        if (isset($inputs['noti'])) {
            Notification::whereId($inputs['noti'])
                        ->where('user_id', auth()->user()->id)
                        ->update(['status' => 1]);
        }

        return view("customers.pages.missions.list", [
            'missions' => $missions->get()->groupBy('date'),
            "inputs" => $inputs
        ]);
    }

    public function createLogMission($id, $request, $mission, $is_expired)
    {
        return LogMission::updateOrCreate(
            [
                "mission_id" => $id,
                "status" => $request->status
            ], [
                "user_id" => $mission->user_id,
                "date" => $mission->date,
                "is_expired" => $is_expired
            ]
        );
    }

    public function addJob()
    {
        $projects = Project::all();

        return view("customers.pages.jobs.add", [
            'projects' => $projects
        ]);
    }

    public function storeJob(Request $request)
    {
        $datas = [];
        $this->validate($request, [
            "keyword" => "required"
        ]);
        foreach (explode(",", $request->keyword) as $keywordItem) {
            $datas[] = [
                "user_id" => auth()->user()->id,
                "keyword" => $keywordItem,
                "project_id" => $request->project_id,
                "date" => date("Y-m-d"),
                "deadline" => date("Y-m-d"),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ];
        }
        Mission::insert($datas);

        return back()->with("success", "Thêm thành công");
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            "status" => $request->status
        ];
        if ($request->status == 5 && empty($request->url_publish)) {
            return back()->with("error", "Cần nhập link publish");
        } else if ($request->status == 1 && empty($request->url)) {
            return back()->with("error", "Cần nhập link hoàn thành");
        }
        try {
            $mission = Mission::find($id);
            DB::beginTransaction();
            if ($mission->status == 0 && $request->status == 1) {
                $dataUpdate["date_done"] = date("Y-m-d");
                $this->createLogMission($id, $request, $mission, strtotime(date("Y-m-d")) > strtotime($mission->deadline) ? 1 : 0);
            } else if ($mission->status == 2 && $request->status == 4) {
                $this->createLogMission($id, $request, $mission, strtotime(date("Y-m-d")) > strtotime($mission->deadline_edit) ? 1 : 0);
            } else if ($mission->status == 3 && $request->status == 5) {
                $this->createLogMission($id, $request, $mission, strtotime(date("Y-m-d")) > strtotime($mission->deadline_publish) ? 1 : 0);
            }
            if (!empty($request->url)) {
                $dataUpdate["url"] = $request->url;
                $notification = Notification::create([
                    "name" => "Từ khóa <b>$mission->keyword</b> đã được cập nhật url",
                    "url" => route('admin.mission.list', ['keyword' => $mission->keyword]),
                    "status" => 0
                ]);
                Notification::whereId($notification->id)
                            ->update([
                                "url" => route('admin.mission.list', ['keyword' => $mission->keyword, "noti" => $notification->id])
                            ]);
            }
            if (!empty($request->url_publish)) {
                $dataUpdate["url_publish"] = $request->url_publish;
            }
            Mission::whereId($id)
                    ->update($dataUpdate);
            DB::commit();

            return back()->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            DB::commit();
dd($th->getMessage());
            return back()->with("error", "Vui lòng thử lại");
        }
    }

    public function getListCommentById($mission_id)
    {
        try {
            $datas = [];
            $comments = Comment::where('mission_id', $mission_id)
                           ->oldest()
                           ->with(['user', 'admin'])
                           ->get();
            foreach ($comments as $cmtItem) {
                $datas[] = [
                    "message" => $cmtItem->message,
                    "sender_name" => !empty($cmtItem->user) ? $cmtItem->user->full_name : $cmtItem->admin->full_name,
                    "is_user" => is_null($cmtItem->user_id) ? false : true,
                    "time" => $cmtItem->created_at->format('H:i d/m/Y')
                ];
            }

            return response()->json([
                "success" => true,
                "data" => $datas
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Vui lòng thử lại"
            ]);
        }
    }

    public function storeComment(Request $request)
    {
        try {
            Comment::create([
                "user_id" => auth()->user()->id,
                "message" => $request->message,
                "mission_id" => $request->mission_id
            ]);

            return response()->json([
                "success" => true,
                "data" => [
                    "message" => $request->message,
                    "sender_name" => auth()->user()->full_name,
                    "is_user" => true,
                    "time" => date('H:i d/m/Y')
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Vui lòng thử lại"
            ]);
        }
    }
}
