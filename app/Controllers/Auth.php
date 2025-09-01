<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AplikasiModel;

class Auth extends BaseController
{
    protected $user;
    protected $aplikasi;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->aplikasi = new AplikasiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Login',
            'aplikasi' => $this->aplikasi->first(), // ambil semua data aplikasi
        ];

        // Gunakan render() agar data global otomatis tersedia di view
        return view('auth/login', $data); // view login
    }

    public function login()
    {
        $session = session();
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        if (empty($login) || empty($password)) {
            $session->setFlashdata('error', 'Email/Username dan password wajib diisi');
            return redirect()->to('/auth');
        }

        $user = $this->user
            ->where('email', $login)
            ->orWhere('username', $login)
            ->first();

        if (!$user) {
            $session->setFlashdata('error', 'Email atau Username tidak ditemukan');
            return redirect()->to('/auth');
        }

        if (!password_verify($password, $user['password'])) {
            $session->setFlashdata('error', 'Password salah');
            return redirect()->to('/auth');
        }

        // Set session lengkap dengan role_id
        $sessionData = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'username' => $user['username'],
            'name' => $user['name'],
            'role_id' => $user['role_id'], // penting untuk role check
            'isLoggedIn' => true,
            'last_activity' => time(),          // simpan timestamp login
        ];
        $session->set($sessionData);

        $session->setFlashdata('success', 'Berhasil login!');
        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        $session = session();
        $session->setFlashdata('success', 'Berhasil logout!');
        $session->remove(['user_id', 'email', 'username', 'name', 'role_id', 'isLoggedIn']);
        return redirect()->to('/auth');
    }
}
