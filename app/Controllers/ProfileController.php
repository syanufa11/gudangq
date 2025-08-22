<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Profil Saya',
            'users' => $user
        ];

        return $this->render('profile', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id'); // pastikan session sudah ada

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email')
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // Validasi tipe file
            $allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
            if (!in_array($foto->getMimeType(), $allowedTypes)) {
                return redirect()->back()->with('error', 'Foto harus berupa PNG, JPG, atau JPEG!');
            }

            // Validasi ukuran max 2MB
            if ($foto->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran foto maksimal 2MB!');
            }

            $newName = $foto->getRandomName();
            $uploadPath = FCPATH . 'uploads/users/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $foto->move($uploadPath, $newName);
            $data['foto'] = 'uploads/users/' . $newName;

            // Hapus foto lama jika ada
            $oldUser = $this->userModel->find($userId);
            if ($oldUser && !empty($oldUser['foto']) && file_exists(FCPATH . $oldUser['foto'])) {
                @unlink(FCPATH . $oldUser['foto']);
            }
        }

        $this->userModel->update($userId, $data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Menampilkan form ubah password
    public function password()
    {
        $data = [
            'title' => 'Ubah Password'
        ];
        return $this->render('ubah_password', $data);
    }

    // Proses ubah password
    public function updatePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Cek password lama
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai!');
        }

        // Cek konfirmasi password
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok!');
        }

        // Hash dan update password baru
        $this->userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }


}
