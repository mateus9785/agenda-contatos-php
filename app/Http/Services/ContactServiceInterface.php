<?php

namespace App\Http\Services;

interface ContactServiceInterface
{
    public function index($group_id, $search, $per_page = 10);

    public function show($id);

    public function store($name, $name_file, $groups, $phones, $addresses);

    public function update($id, $name, $name_file, $groups, $phones, $addresses);

    public function destroy(int $id);
}
