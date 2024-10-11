<?php

namespace App\Repositories\Roles;

use App\Repositories\RepositoryInterface;

interface RoleInterface extends RepositoryInterface
{
    public function findRoleByCode($code);
}