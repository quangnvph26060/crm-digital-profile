<?php

namespace App\Repositories\Admins;

use App\Repositories\RepositoryInterface;

interface AdminInterface extends RepositoryInterface
{
    public function getEmployee($inputs);
}