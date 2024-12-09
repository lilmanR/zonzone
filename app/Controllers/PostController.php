<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\NotificationModel;
use CodeIgniter\Controller;

class PostController extends Controller
{
    protected $postModel;
    protected $commentModel;
    protected $notificationModel;
    protected $session;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->commentModel = new CommentModel();
        $this->notificationModel = new NotificationModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $userName = $this->session->get('username');
        $data['posts'] = $this->postModel->getPosts();
        $data['notifications'] = $this->notificationModel->getUnreadNotifications($userName);
        $data['trendingPosts'] = $this->postModel->getTrendingPosts();
        return view('dashboard', $data);
    }

    public function createPost()
    {
        $userName = $this->session->get('username');
        $imageFile = $this->request->getFile('image');
        $imagePath = '';

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads', $imageName);
            $imagePath = 'uploads/' . $imageName;
        }

        $postData = [
            'user_name' => $userName,
            'post_text' => $this->request->getPost('post_text'),
            'image_path' => $imagePath,
        ];

        $this->postModel->save($postData);
        return redirect()->to('/dashboard');
    }

    public function getNotifications()
{
    $userName = $this->session->get('username');
    $notifications = $this->notificationModel->getUnreadNotifications($userName);

    return $this->response->setJSON($notifications);
}

    public function markNotificationsAsRead()
    {
        $userName = $this->session->get('username');
        $this->notificationModel->markAsRead($userName);
        return $this->response->setJSON(['success' => true]);
    }

    public function getPostComments($postId)
    {
        $comments = $this->commentModel->getCommentsByPostId($postId);

        foreach ($comments as &$comment) {
            $comment['replies'] = $this->commentModel->getRepliesByCommentId($comment['id']);
        }

        return $this->response->setJSON($comments);
    }

    public function addComment()
{
    $postId = $this->request->getPost('post_id');
    $commentText = $this->request->getPost('comment_text');
    $userName = $this->session->get('username');

    // Simpan komentar
    $this->commentModel->save([
        'post_id' => $postId,
        'user_name' => $userName,
        'comment_text' => $commentText,
        'parent_comment_id' => null,
    ]);

    // Dapatkan data pemilik postingan
    $post = $this->postModel->find($postId);

    // Pastikan pemilik postingan tidak menerima notifikasi dari dirinya sendiri
    if ($post['user_name'] !== $userName) {
        $this->notificationModel->save([
            'user_name' => $post['user_name'],
            'post_id' => $postId,
            'comment_user' => $userName,
            'seen' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'parent_comment_id' => null,
        ]);
    }

    return $this->response->setJSON(['success' => true]);
}


public function addReply()
{
    $postId = $this->request->getPost('post_id');
    $commentText = $this->request->getPost('reply_text');
    $parentCommentId = $this->request->getPost('parent_comment_id');
    $userName = $this->session->get('username');

    // Simpan balasan
    $this->commentModel->addReply([
        'post_id' => $postId,
        'user_name' => $userName,
        'comment_text' => $commentText,
        'parent_comment_id' => $parentCommentId,
    ]);

    // Dapatkan data pemilik komentar
    $parentComment = $this->commentModel->find($parentCommentId);

    // Pastikan pemilik komentar tidak menerima notifikasi dari dirinya sendiri
    if ($parentComment['user_name'] !== $userName) {
        $this->notificationModel->save([
            'user_name' => $parentComment['user_name'],
            'post_id' => $postId,
            'comment_user' => $userName,
            'seen' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'parent_comment_id' => $parentCommentId,
        ]);
    }

    return $this->response->setJSON(['success' => true]);
}
    public function markNotificationAndShowComments($notificationId)
{
    // Mark the notification as read
    $this->notificationModel->update($notificationId, ['seen' => 1]);

    // Get the associated post_id from notification
    $notification = $this->notificationModel->find($notificationId);
    if ($notification) {
        $postId = $notification['post_id'];
        $comments = $this->commentModel->getCommentsByPostId($postId);

        foreach ($comments as &$comment) {
            $comment['replies'] = $this->commentModel->getRepliesByCommentId($comment['id']);
        }

        return $this->response->setJSON($comments);
    }

    return $this->response->setJSON(['error' => 'Notification or Post not found'], 404);
}
public function checkNewComments($postId)
{
    // Ambil komentar pada post tertentu
    $comments = $this->commentModel->getCommentsByPostId($postId);

    // Sertakan balasan untuk setiap komentar
    foreach ($comments as &$comment) {
        $comment['replies'] = $this->commentModel->getRepliesByCommentId($comment['id']);
    }

    return $this->response->setJSON($comments);
}

public function checkNotifications()
{
    $userName = $this->session->get('username');

    // Ambil notifikasi yang belum dibaca
    $notifications = $this->notificationModel->getUnreadNotifications($userName);

    if ($notifications) {
        // Render notifikasi ke dalam HTML (sesuai format frontend Anda)
        $html = '';
        foreach ($notifications as $notif) {
            $html .= "
                <a class='dropdown-item' href='#' onclick='showNotificationDetails({$notif['id']}, {$notif['post_id']})'>
                    <strong>{$notif['comment_user']}</strong> mengomentari postingan Anda
                </a>";
        }
        return $this->response->setJSON(['new_notifications' => true, 'html' => $html]);
    }

    return $this->response->setJSON(['new_notifications' => false]);
}
public function trendingPosts()
{
    $data['trendingPosts'] = $this->postModel->getTrendingPosts();
    return view('trending_today', $data); // Sesuaikan nama view
}
public function details($id)
{
    $post = $this->postModel->getPostById($id); // Ganti dengan metode yang sesuai untuk mendapatkan data postingan
    if ($post) {
        return $this->response->setJSON($post);
    } else {
        return $this->response->setJSON(['error' => 'Postingan tidak ditemukan.']);
    }
}

public function showTrendingPosts()
{
    // Ambil data postingan trending
    $data['posts'] = $this->postModel->getTrendingPostsWithDetails();
    $data['title'] = 'Trending Today'; // Judul Halaman

    return view('post_list', $data); // Pastikan Anda memiliki view yang sesuai
}

}
