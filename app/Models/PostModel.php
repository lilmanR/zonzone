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
public function getTrendingPosts()
{
    return $this->db->table('posts')
                    ->select('posts.id, posts.post_text, posts.image_path, COUNT(comments.id) as jumlah_komentar')
                    ->join('comments', 'comments.post_id = posts.id', 'left')
                    ->groupBy('posts.id')
                    ->orderBy('jumlah_komentar', 'DESC')
                    ->limit(3) // Ambil 5 postingan teratas
                    ->get()
                    ->getResultArray();
}
public function getPostById($id)
{
    return $this->db->table('posts')
        ->select('posts.*, users.nama_lengkap, users.jurusan, users.fprofile')
        ->join('users', 'posts.user_id = users.id')
        ->where('posts.id', $id)
        ->get()
        ->getRowArray();
}


}
