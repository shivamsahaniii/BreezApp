<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function updateProfile(array $data, $userId): void;
}