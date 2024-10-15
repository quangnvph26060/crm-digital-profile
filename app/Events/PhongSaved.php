<?php

namespace App\Events;

use App\Models\MucLuc;
use App\Models\Phong;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PhongSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $phong;
    public function __construct(Phong $phong)
    {
       
        $this->phong = $phong;
    }

    public function handle()
    {
        $muclucs = MucLuc::all();

        $data = $muclucs->map(function ($mucluc) {
            return [
                'phong_id' => $this->phong->id,
                'mucluc_id' => $mucluc->id,
            ];
        })->toArray();

        // Thêm dữ liệu vào bảng trung gian
        DB::table('phong_mucluc')->insertUsing(
            ['phong_id', 'mucluc_id'],
            $data
        );
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
