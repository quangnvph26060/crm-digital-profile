<?php

namespace App\Imports;

use App\Models\Comment;
use App\Models\Mission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MissionImport implements ToCollection, WithHeadingRow
{
    protected $inputs;

    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            $datas = [];
            foreach ($rows as $row)
            {
                $datas[] = [
                    "project_id" => $this->inputs['project_id'],
                    "user_id" => $this->inputs['user_id'],
                    "deadline" => $this->inputs['deadline'],
                    "deadline_edit" => empty($this->inputs["deadline_edit"]) ? NULL : $this->inputs["deadline_edit"],
                    "deadline_publish" => empty($this->inputs["deadline_publish"]) ? NULL : $this->inputs["deadline_publish"],
                    "keyword" => $row['keyword'],
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                    "date" => date('Y-m-d')
                ];
            }
            Mission::insert($datas);
            if ($this->inputs['message'] != '') {
                $missions = Mission::latest('id')->take(count($datas))->get();
                foreach ($missions as $item) {
                    $comments[] = [
                        "admin_id" => auth('admin')->user()->id,
                        "message" => $this->inputs['message'],
                        "mission_id" => $item->id,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ];
                }
                Comment::insert($comments);
            }
            DB::commit();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
