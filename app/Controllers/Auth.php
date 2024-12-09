<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
{
    $session = session();
    $model = new UserModel();
    
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $user = $model->where('username', $username)->first();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $sessionData = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'logged_in' => true,
            ];
            $session->set($sessionData);

            // Periksa apakah username adalah 'admin'
            if ($username === 'hilman') {
                return redirect()->to('/admin'); // Arahkan ke halaman admin
            }

            return redirect()->to('/dashboard'); // Arahkan ke halaman dashboard untuk user biasa
        } else {
            $session->setFlashdata('msg', 'Password salah');
            return redirect()->to('/login');
        }
    } else {
        $session->setFlashdata('msg', 'Username tidak ditemukan');
        return redirect()->to('/login');
    }
}

    public function register()
    {
        return view('auth/register');
    }
    
    public function processRegister()
{
    $model = new UserModel();
    $file = $this->request->getFile('fprofile');

    $data = [
        'username'    => $this->request->getPost('username'),
        'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'nama_lengkap'=> $this->request->getPost('nama_lengkap'),
        'jurusan'     => $this->request->getPost('jurusan'),
        'email'       => $this->request->getPost('email'),
        'fprofile'    => 'default.jpg',  // Set default profile picture
    ];

    // Memeriksa apakah file berhasil diunggah
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $fileName = $file->getRandomName();
        $file->move('uploads/profile_pictures', $fileName);
        $data['fprofile'] = $fileName;  // Set file name only if uploaded successfully
    }

    $model->insert($data);
    session()->setFlashdata('msg', 'Registration successful. Please log in.');
    return redirect()->to('/login');
}
public function logout()
{
    session()->destroy();
    return redirect()->to('/login');
}
}
