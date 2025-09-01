<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;

class RoleController extends BaseController
{
    protected $role;

    public function __construct()
    {
        $this->role = new RoleModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Role',
            'roles' => $this->role->orderBy('id', 'DESC')->findAll()
        ];

        return $this->render('role', $data);
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        if (!$name) {
            session()->setFlashdata('error', 'Nama role wajib diisi!');
            return redirect()->to('/role');
        }

        if ($id) {
            $this->role->update($id, ['name' => $name]);
            session()->setFlashdata('success', 'Role berhasil diperbarui!');
        } else {
            $this->role->insert(['name' => $name]);
            session()->setFlashdata('success', 'Role berhasil ditambahkan!');
        }

        return redirect()->to('/role');
    }

    public function delete($id)
    {
        if ($this->role->find($id)) {
            $this->role->delete($id);
            session()->setFlashdata('success', 'Role berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }

        return redirect()->to('/role');
    }
}
