<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class UserController extends BaseController
{
    protected $user;
    protected $role;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->role = new RoleModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->user->getUsersWithRole(),
            'roles' => $this->role->findAll()
        ];

        return $this->render('user', $data);
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role_id = $this->request->getPost('role_id');
        $fotoFile = $this->request->getFile('foto');

        if (!$name || !$username || !$email || !$role_id) {
            session()->setFlashdata('error', 'Nama, username, email, dan role wajib diisi!');
            return redirect()->to('/user');
        }

        // Ambil data lama jika update
        $oldUser = $id ? $this->user->find($id) : null;

        $data = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'role_id' => $role_id
        ];

        // Handle password
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        } elseif (!$id) {
            $data['password'] = password_hash('123456', PASSWORD_DEFAULT);
        }

        // Handle foto
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {

            // Validasi tipe file
            $allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
            if (!in_array($fotoFile->getMimeType(), $allowedTypes)) {
                session()->setFlashdata('error', 'Foto harus berupa PNG, JPG, atau JPEG!');
                return redirect()->to('/user');
            }

            // Validasi ukuran max 2MB
            if ($fotoFile->getSize() > 2 * 1024 * 1024) {
                session()->setFlashdata('error', 'Ukuran foto maksimal 2MB!');
                return redirect()->to('/user');
            }

            $fileName = $fotoFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/users/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $fotoFile->move($uploadPath, $fileName);
            $data['foto'] = 'uploads/users/' . $fileName;

            // Hapus foto lama jika ada
            if ($oldUser && !empty($oldUser['foto']) && file_exists(FCPATH . $oldUser['foto'])) {
                @unlink(FCPATH . $oldUser['foto']);
            }
        }

        // Simpan ke database
        if ($id) {
            $this->user->update($id, $data);
            session()->setFlashdata('success', 'User berhasil diperbarui!');
        } else {
            $this->user->insert($data);
            session()->setFlashdata('success', 'User berhasil ditambahkan!');
        }

        return redirect()->to('/user');
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if ($user) {
            // Hapus foto jika ada
            if (!empty($user['foto']) && file_exists(FCPATH . $user['foto'])) {
                @unlink(FCPATH . $user['foto']);
            }

            $this->user->delete($id);
            session()->setFlashdata('success', 'User berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }

        return redirect()->to('/user');
    }
}
