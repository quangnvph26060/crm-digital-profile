<?php

namespace App\Repositories\PermissionRoles;

use App\Repositories\RepositoryInterface;

interface PermissionRoleInterface extends RepositoryInterface
{
    public function deleteOldRole($role_id);
}