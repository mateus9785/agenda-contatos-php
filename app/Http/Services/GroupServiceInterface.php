<?php

namespace App\Http\Services;

interface GroupServiceInterface
{
    public function index($per_page = 10);

    public function store($name);

    public function update($id, $name);

    public function destroy(int $id);
}
