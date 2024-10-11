<?php

namespace App\Repositories\Users;

use App\Repositories\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    public function findUserByRefCode($ref_code);

    public function updatePassword($email, $password);

    public function checkUserByEmail($email);

    public function getUser($inputs);
}