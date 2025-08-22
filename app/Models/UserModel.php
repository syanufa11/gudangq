<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'role_id', 'name', 'foto'];

    protected $useTimestamps = true; // otomatis set created_at & updated_at
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getUsersWithRole()
    {
        return $this->select('user.*, role.name as role_name')
            ->join('role', 'role.id = user.role_id', 'left')
            ->orderBy('user.id', 'DESC')
            ->findAll();
    }

    public function getUsersById($id)
    {
        return $this->select('user.*, role.name as role_name')
            ->join('role', 'role.id = user.role_id', 'left')
            ->where('user.id', $id)
            ->first();
    }
}
