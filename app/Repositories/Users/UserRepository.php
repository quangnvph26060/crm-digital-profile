<?php

namespace App\Repositories\Users;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function findUserByRefCode($ref_code)
    {
        return $this->model->where('ref_code', $ref_code)->first();
    }

    public function findUserByToken($token)
    {
        return $this->model->where('token', $token)->first();
    }

    public function checkUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function updatePassword($email, $password)
    {
        return $this->model->where('email', $email)
                           ->update(['password' => $password]);
    }

    public function getUser($inputs)
    {
        $users = $this->model->query();

        if (isset($inputs['verify']) && $inputs['verify'] != -1) {
            $users->where(function($query) use ($inputs) {
                if ($inputs['verify'] == 0) {
                    $query->whereNull('email_verified_at');
                } else if ($inputs['verify'] == 1) {
                    $query->whereNotNull('email_verified_at');
                }
            });
        }
        if (isset($inputs['name'])) {
            $users->where(function($query) use ($inputs) {
                $query->where('full_name', 'like', '%' . $inputs['name'] . '%')
                      ->orWhere('shop_name', 'like', '%' . $inputs['name'] . '%')
                      ->orWhere('email', 'like', '%' . $inputs['name'] . '%')
                      ->orWhere('phone', 'like', '%' . $inputs['name'] . '%');
            });
        }
        if (isset($inputs['type_account']) && $inputs['type_account'] != -1) {
            $users->where('type', $inputs['type_account']);
        }
        if (isset($inputs['status']) && $inputs['status'] != -1) {
            $users->where('status', $inputs['status']);
        }
        //dd($users->get());

        return $users->with(['parent', 'role'])->latest()->paginate(20);
    }
}
