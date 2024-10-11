<?php

namespace App\Repositories\PutMoney;

use App\Repositories\BaseRepository;

class PutMoneyRepository extends BaseRepository implements PutMoneyInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\PutMoney::class;
    }

    public function list($inputs)
    {
        $listPutMoneys = $this->model->query();

        if (isset($inputs['date'])) {
            $listPutMoneys->whereBetween('created_at', [$inputs['date'] . ' 00:00:00', $inputs['date'] . ' 23:59:59']);
        }
        if (isset($inputs['key_search'])) {
            $listPutMoneys->whereHas('shop', function ($query) use ($inputs) {
                $query->where('email', 'like', '%' . $inputs['key_search'] . '%')
                      ->orWhere('full_name', 'like', '%' . $inputs['key_search'] . '%')
                      ->orWhere('ref_code', 'like', '%' . $inputs['key_search'] . '%');
            });
        }
        

        return $listPutMoneys->with(['shop', 'user'])->latest()->paginate(20);
    }

    public function getPutMoneyByUser($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }
}
