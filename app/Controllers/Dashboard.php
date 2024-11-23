<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Mengecek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Menampilkan halaman dashboard
        return view('dashboard/index');
    }
}
