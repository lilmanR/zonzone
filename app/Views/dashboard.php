<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            justify-content: center;
            margin: 0;
            
        }
        .post-container {
            max-width: 800px;
            margin: auto;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn-file {
            gap: 5px;
            font-size: 1rem;
        }
        .btn-file input[type="file"] {
            display: none;
        }
        .post-content img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 10px;
        }
        .post-author {
            font-weight: bold;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }
        .post-details {
            color: #666;
        }
        .post-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }
        .comments-button {
            color: #007bff;
            cursor: pointer;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .comment-container {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
}
.comment-author {
    font-weight: bold;
}
.comment-time {
    color: #999;
    font-size: 0.85em;
}
.reply-button {
    color: #007bff;
    font-size: 0.85em;
    cursor: pointer;
}
.profile-picture {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <a class="navbar-brand" href="#">Zz</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown mr-3">
                    <a class="nav-link" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notifDropdown" id="notificationContainer">
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $notification): ?>
            <a class="dropdown-item" href="javascript:void(0);" onclick="showNotificationDetails(<?= $notification['id'] ?>)">
                <strong><?= esc($notification['nama_lengkap']) ?></strong>
                <span class="badge badge-pill badge-secondary"><?= esc($notification['jurusan']) ?></span>
                
                <!-- Tampilkan teks berbeda berdasarkan nilai parent_comment_id -->
                <?php if ($notification['parent_comment_id'] === null): ?>
                    mengomentari postingan Anda
                <?php else: ?>
                    membalas komentar Anda
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
        <div class="dropdown-divider"></div>
        <a href="javascript:void(0);" class="dropdown-item text-center" onclick="markAllAsRead()">Tandai Semua Telah Dibaca</a>
    <?php else: ?>
        <p class="dropdown-item">Tidak ada notifikasi.</p>
    <?php endif; ?>
</div>
                </li>
                <li class="nav-item dropdown mr-3">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" id="profileLink">Profile</a>
                        <a class="dropdown-item" href="<?= site_url('/logout') ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-5">
        <div class="post-container">
            <h3>Buat Postingan</h3>
            <form action="/post/createPost" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <textarea class="form-control" name="post_text" placeholder="Apa yang Anda pikirkan?" required></textarea>
    </div>
    <div class="form-group">
        <label class="btn btn-light btn-file">
            <i class="fas fa-camera"></i> Pilih Foto
            <input type="file" name="image" accept="image/*" id="imageUpload" onchange="previewImage(event)">
        </label>
        <div id="imageContainer" class="mt-2" style="position: relative; display: none;">
            <img id="imagePreview" style="width: 30%; border-radius: 8px;" alt="Pratinjau Gambar">
            <button type="button" id="clearPreview" onclick="removeImage()" style="position: center; top: 5px; right: 5px; background: #ffffff80; border: none; font-weight: bold; color: red;"> <i class="fas fa-times"></i></button>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Posting</button>
</form>
        </div>

        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-container">
                    <div class="post-header">
                    <h5 class="post-author"><img src="<?= base_url('uploads/profile_pictures/' . $post['fprofile']) ?>" class="profile-picture"><?= esc($post['nama_lengkap']) ?> <span class="badge badge-pill badge-secondary"><?= esc($post['jurusan']) ?></span></h5>
                    </div>
                    <div class="post-content">
                        <p><?= esc($post['post_text']) ?></p>
                        <?php if ($post['image_path']): ?>
                            <img src="<?= base_url($post['image_path']) ?>" alt="Image" class="img-fluid">
                        <?php endif; ?>
                    </div>
                    <div class="post-footer mt-3">
                        <span class="post-details"><?= $post['post_date'] ?></span>
                        <span class="post-details"><strong><?= $post['jumlah_komentar'] ?> Komentar</strong></span>
                    </div>
                    <button class="btn btn-link" onclick="openComments(<?= $post['id'] ?>)">Lihat Komentar</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Modal for displaying comments -->
    <div id="postModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Komentar Postingan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modalCommentsBody">
                    <!-- Komentar dan balasan akan dimuat di sini -->
                </div>
                <div class="modal-footer">
                    <form id="commentForm">
                        <textarea name="comment_text" class="form-control" placeholder="Tambahkan komentar..." required></textarea>
                        <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Profile Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
        <!-- Tabel Informasi Pengguna -->
        <table class="table">
          <tr>
            <th>Nama Lengkap</th>
            <td id="namaLengkap"></td>
          </tr>
          <tr>
            <th>Jurusan</th>
            <td id="jurusan"></td>
          </tr>
          <tr>
            <th>Username</th>
            <td id="username"></td>
          </tr>
          <tr>
            <th>Email</th>
            <td id="email"></td>
          </tr>
        </table>
        
        <!-- Form untuk Mengganti Foto Profil -->
        <form id="profilePictureForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="profilePicture" class="form-label">Ganti Foto Profil</label>
            <input class="form-control" type="file" id="profilePicture" name="profilePicture">
          </div>
          <button type="submit" class="btn btn-primary">Unggah Foto</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    let currentPostId;

    function openComments(postId, notificationId = null) {
        currentPostId = postId;
        // Jika ada notificationId, tandai sebagai sudah dibaca
        if (notificationId) {
            $.ajax({
                url: `/post/markNotificationAndShowComments/${notificationId}`,
                type: 'GET',
                success: function(data) {
                    updateCommentsModal(data);
                }
            });
        } else {
            $.ajax({
                url: `/post/comments/${postId}`,
                type: 'GET',
                success: function(data) {
                    updateCommentsModal(data);
                }
            });
        }
    }

    function updateCommentsModal(data) {
        let commentsHTML = '';
        data.forEach(comment => {
            commentsHTML += `
                <div class="comment-container">
                    <div class="comment-author">${comment.nama_lengkap} <span class="badge badge-pill badge-secondary">${comment.jurusan}</span></div>
                    <div class="comment-text">${comment.comment_text}</div>
                    <button class="btn btn-link btn-sm" onclick="showReplyForm(${comment.id})">Balas</button>
                    <div id="replyForm-${comment.id}" class="reply-form" style="display:none;">
                        <form onsubmit="submitReply(event, ${comment.id})">
                            <textarea name="reply_text" class="form-control" placeholder="Tulis balasan..." required></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Kirim</button>
                        </form>
                    </div>
                </div>`;

            if (comment.replies) {
                comment.replies.forEach(reply => {
                    commentsHTML += `
                        <div class="comment-container ml-4">
                            <div class="comment-author">${reply.nama_lengkap} <span class="badge badge-pill badge-secondary">${reply.jurusan}</span></div>
                            <div class="comment-text">${reply.comment_text}</div>
                        </div>`;
                });
            }
        });
        $('#modalCommentsBody').html(commentsHTML);
        $('#postModal').modal('show');
    }

    function showReplyForm(commentId) {
        $(`#replyForm-${commentId}`).toggle();
    }

    function submitReply(e, parentCommentId) {
        e.preventDefault();
        $.post(`/post/addReply`, {
            post_id: currentPostId,
            reply_text: e.target.reply_text.value,
            parent_comment_id: parentCommentId
        }, function(response) {
            if (response.success) {
                openComments(currentPostId); // Reload comments
            }
        });
    }

    $('#commentForm').submit(function(e) {
        e.preventDefault();
        $.post(`/post/addComment`, $(this).serialize() + `&post_id=${currentPostId}`, function(response) {
            if (response.success) {
                openComments(currentPostId); // Reload comments
            }
        });
    });

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            const container = document.getElementById('imageContainer');
            output.src = reader.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function removeImage() {
        const output = document.getElementById('imagePreview');
        const container = document.getElementById('imageContainer');
        const inputFile = document.getElementById('imageUpload');
        container.style.display = 'none';
        output.src = '';
        inputFile.value = '';
    }

    // Menampilkan detail notifikasi dan komentar
    function showNotificationDetails(notificationId, postId) {
        openComments(postId, notificationId);
    }

    // Menandai semua notifikasi sebagai telah dibaca
    function markAllAsRead() {
        $.ajax({
            url: '/post/markNotificationsAsRead',
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    $('#notificationContainer').html('<p class="dropdown-item">Tidak ada notifikasi.</p>');
                }
            }
        });
    }
    document.getElementById('profileLink').addEventListener('click', function () {
  fetch('/user/profile')
    .then(response => response.json())
    .then(data => {
      document.getElementById('namaLengkap').innerText = data.nama_lengkap;
      document.getElementById('jurusan').innerText = data.jurusan;
      document.getElementById('username').innerText = data.username;
      document.getElementById('email').innerText = data.email;
      new bootstrap.Modal(document.getElementById('profileModal')).show();
    });
});

// Handle profile picture form submission
document.getElementById('profilePictureForm').addEventListener('submit', function (e) {
  e.preventDefault();
  let formData = new FormData(this);
  fetch('/user/updateProfilePicture', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Foto profil berhasil diubah!');
      location.reload();
    } else {
      alert('Terjadi kesalahan, coba lagi.');
    }
  });
});

</script>

</body>
</html>
