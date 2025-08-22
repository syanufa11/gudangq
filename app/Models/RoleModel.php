<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
    protected $useTimestamps = true; // otomatis set created_at & updated_at
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

}
