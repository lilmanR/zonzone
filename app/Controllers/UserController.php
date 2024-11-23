<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function profile()
    {
        $session = \Config\Services::session();
        $userName = $session->get('username');
        $user = $this->userModel->where('username', $userName)->first();

        return $this->response->setJSON($user);
    }

    public function updateProfilePicture()
    {
        $session = \Config\Services::session();
        $userName = $session->get('username');

        $file = $this->request->getFile('profilePicture');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile_pictures', $newName);

            // Update user profile picture in the database
            $this->userModel->where('username', $userName)->set('fprofile',  $newName)->update();

            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false]);
    }
}
