<?php

namespace App\Services\Admins;

use Illuminate\Support\Facades\DB;

class SettingService
{
    public function smtpForm()
    {
        return [
            'smtpConfig' => DB::table('smtps')->first()
        ];
    }

    public function storeSmtp($inputs)
    {
        try {
            DB::table('smtps')->whereId(1)->update($inputs);

            return [
                'success' => 'success',
                'message' => 'Cài đặt thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => 'error',
                'message' => 'Vui lòng thử lại'
            ];
        }
    }
}