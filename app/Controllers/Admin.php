<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\NotificationModel;

class Admin extends BaseController
{
    protected $userModel;
    protected $postModel;
    protected $commentModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->postModel = new PostModel();
        $this->commentModel = new CommentModel();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        // Ambil semua data dari database untuk ditampilkan di dashboard admin
        $users = $this->userModel->findAll();
        $posts = $this->postModel->findAll();
        $comments = $this->commentModel->findAll();
        $notifications = $this->notificationModel->findAll();

        return view('admin/dashboard', [
            'users' => $users,
            'posts' => $posts,
            'comments' => $comments,
            'notifications' => $notifications,
        ]);
    }

    public function deleteUser($id)
    {
        // Hapus user berdasarkan ID
        $this->userModel->delete($id);
        return redirect()->to('/admin')->with('message', 'User berhasil dihapus!');
    }

    public function deletePost($id)
    {
        // Hapus post berdasarkan ID
        $this->postModel->delete($id);
        return redirect()->to('/admin')->with('message', 'Post berhasil dihapus!');
    }

    public function deleteComment($id)
    {
        // Hapus komentar berdasarkan ID
        $this->commentModel->delete($id);
        return redirect()->to('/admin')->with('message', 'Komentar berhasil dihapus!');
    }

    public function markNotificationSeen($id)
    {
        // Tandai notifikasi sebagai sudah dibaca
        $this->notificationModel->update($id, ['seen' => 1]);
        return redirect()->to('/admin')->with('message', 'Notifikasi ditandai sebagai sudah dibaca!');
    }
}
