<?php

namespace App\Repositories\Permissions;

use App\Repositories\RepositoryInterface;

interface PermissionInterface extends RepositoryInterface
{
    public function checkExistPms($code, $idExcept = NULL);

    public function list();
}