<?php

namespace App\Helpers;

namespace App\Http\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();

    public function get();

    public function update($id, $req);

    public function store($user);
}
