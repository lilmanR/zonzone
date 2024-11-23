<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_name', 'post_text', 'post_date', 'image_path'];

    public function getPosts()
{
    return $this->db->table($this->table)
        ->select('posts.*, users.nama_lengkap, users.fprofile, users.jurusan, COUNT(comments.post_id) as jumlah_komentar')
        ->join('users', 'users.username = posts.user_name')
        ->join('comments', 'comments.post_id = posts.id', 'left') // Left join untuk menghitung meskipun tidak ada komentar
        ->groupBy('posts.id') // Kelompokkan berdasarkan ID post agar COUNT berfungsi per post
        ->orderBy('post_date', 'DESC')
        ->get()
        ->getResultArray();
}
}
