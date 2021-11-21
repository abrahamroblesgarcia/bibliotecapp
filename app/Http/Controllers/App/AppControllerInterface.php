<?php 
namespace App\Http\Controllers\App;

interface AppControllerInterface
{
    public function show(int $id);

    public function showAll();

    public function create(Array $fields);

    public function update(Array $fields);

    public function delete(int $id);
}
