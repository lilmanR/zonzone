<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_name', 'post_id', 'comment_user', 'seen', 'created_at', 'parent_comment_id'];

    public function sendNotification($data)
    {
        return $this->insert($data);
    }

    public function getUnreadNotifications($userName)
{
    return $this->select('notifications.*, users.nama_lengkap, users.jurusan')
                ->join('users', 'users.username = notifications.comment_user')
                ->where(['notifications.user_name' => $userName, 'notifications.seen' => 0])
                ->orderBy('notifications.created_at', 'DESC')
                ->findAll();
}

    public function markAsRead($userName)
    {
        return $this->where('user_name', $userName)
                    ->set(['seen' => 1])
                    ->update();
    }
    
}
