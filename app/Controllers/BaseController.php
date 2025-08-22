<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\AplikasiModel;

abstract class BaseController extends Controller
{
    protected $data = []; // data global
    protected $session;
    protected $userModel;
    protected $roleModel;
    protected $aplikasiModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        // Load session dan models
        $this->session = service('session');
        $this->userModel = new UserModel();
        $this->aplikasiModel = new AplikasiModel();

        // Data global aplikasi harus tetap tampil di semua halaman
        $this->data['aplikasi'] = $this->aplikasiModel->first();

        // Ambil user yang login (jika ada)
        $userId = $this->session->get('isLoggedIn') ? $this->session->get('user_id') : null;
        $this->data['user'] = $this->getUserData($userId);
    }

    // Ambil data user lengkap dengan role dan foto
    protected function getUserData($userId = null)
    {
        if (!$userId) {
            return $this->guestUser();
        }

        $user = $this->userModel->getUsersById($userId);

        if ($user) {
            $user['foto'] = (isset($user['foto']) && file_exists(FCPATH . $user['foto']))
                ? base_url($user['foto'])
                : base_url('template/html/images/user/user.png');
        } else {
            $user = $this->guestUser();
        }

        return $user;
    }

    // User default jika belum login
    protected function guestUser()
    {
        return [
            'name' => 'Guest',
            'role_name' => 'Tidak ada role',
            'foto' => base_url('template/html/images/user/user.png')
        ];
    }

    // Helper untuk load view dengan data global
    protected function render($view, $data = [])
    {
        echo view($view, array_merge($this->data, $data));
    }
}
