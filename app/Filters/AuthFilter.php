<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    // Waktu timeout dalam detik (contoh: 15 menit)
    protected $timeout = 900; // 15 * 60 detik

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1️⃣ Cek login
        if (!$session->get('isLoggedIn')) {
            $session->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('/auth');
        }

        // 2️⃣ Cek timeout
        $lastActivity = $session->get('last_activity');
        $now = time();

        if ($lastActivity && ($now - $lastActivity) > $this->timeout) {
            // logout otomatis karena idle
            $session->destroy();
            session()->setFlashdata('error', 'Anda telah logout karena tidak aktif selama 15 menit.');
            return redirect()->to('/auth');
        }

        // update last activity
        $session->set('last_activity', $now);

        // 3️⃣ Cek role jika $arguments diisi
        if ($arguments) {
            $allowedRoles = $arguments; // contoh: ['1','2']
            $userRole = $session->get('role_id');

            if (!in_array($userRole, $allowedRoles)) {
                $session->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
                return redirect()->to('/forbidden');
            }
        }
    }

    public function after(RequestInterface $request, $response, $arguments = null)
    {
        // tidak ada aksi setelah request
    }
}
