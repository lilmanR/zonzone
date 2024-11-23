<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['post_id', 'user_name', 'comment_text', 'comment_date', 'parent_comment_id'];
    
    public function getCommentsByPostId($postId)
    {
        return $this->select('comments.*, users.nama_lengkap, users.jurusan')
                    ->join('users', 'users.username = comments.user_name')
                    ->where('comments.post_id', $postId)
                    ->where('comments.parent_comment_id', null)
                    ->findAll();
    }

    public function getRepliesByCommentId($commentId)
    {
        return $this->select('comments.*, users.nama_lengkap, users.jurusan')
                    ->join('users', 'users.username = comments.user_name')
                    ->where('comments.parent_comment_id', $commentId)
                    ->findAll();
    }

    public function addReply($data)
    {
        return $this->insert($data);
    }
}
