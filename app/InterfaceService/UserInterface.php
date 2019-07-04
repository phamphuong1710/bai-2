<?php

namespace App\InterfaceService;

interface UserInterface {
    public function getAllUser();
    public function getUserByID($id);
    public function updateUser($request, $id);
    public function createUser($request);
}
