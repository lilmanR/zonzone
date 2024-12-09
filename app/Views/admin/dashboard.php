<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script>
        function filterTable(inputId, tableId) {
            const input = document.getElementById(inputId);
            const filter = input.value.toLowerCase();
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? '' : 'none';
            }
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/dashboard') ?>">Dashboard User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/logout') ?>">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1>Welcome, Admin!</h1>
        <p class="lead">This is the admin dashboard where you can manage the application.</p>

        <!-- Manage Sections -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">Edit and delete user accounts.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manageUsersModal">Open</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Posts</h5>
                        <p class="card-text">Remove inappropriate posts.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#managePostsModal">Open</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Comments</h5>
                        <p class="card-text">Delete user comments.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manageCommentsModal">Open</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Manage Users -->
    <div class="modal fade" id="manageUsersModal" tabindex="-1" aria-labelledby="manageUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageUsersModalLabel">Manage Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="filterUsers" class="form-control mb-3" placeholder="Search by Full Name" 
                           onkeyup="filterTable('filterUsers', 'usersTable')">
                    <table class="table table-striped" id="usersTable">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>ID</th>
                                <th>Username</th>
                                <th>FullName</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <img src="<?= base_url('uploads/profile_pictures/' . $user['fprofile']) ?>" 
                                             alt="Profile Picture" class="img-thumbnail" style="width: 50px; height: 50px;">
                                    </td>
                                    <td><?= esc($user['id']) ?></td>
                                    <td><?= esc($user['username']) ?></td>
                                    <td><?= esc($user['nama_lengkap']) ?></td>
                                    <td><?= esc($user['jurusan']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/delete-user/' . $user['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Manage Posts -->
    <div class="modal fade" id="managePostsModal" tabindex="-1" aria-labelledby="managePostsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="managePostsModalLabel">Manage Posts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="filterPosts" class="form-control mb-3" placeholder="Search by Full Name" 
                           onkeyup="filterTable('filterPosts', 'postsTable')">
                    <table class="table table-striped" id="postsTable">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Content</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td>
                                        <?php if ($post['image_path']): ?>
                                            <img src="<?= base_url($post['image_path']) ?>" 
                                                 alt="Post Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                                        <?php else: ?>
                                            <span>No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($post['id']) ?></td>
                                    <td><?= esc($post['user_name']) ?></td>
                                    <td><?= esc($post['post_text']) ?></td>
                                    <td><?= esc($post['post_date']) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/delete-post/' . $post['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Manage Comments -->
    <div class="modal fade" id="manageCommentsModal" tabindex="-1" aria-labelledby="manageCommentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageCommentsModalLabel">Manage Comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="filterComments" class="form-control mb-3" placeholder="Search by Full Name" 
                           onkeyup="filterTable('filterComments', 'commentsTable')">
                    <table class="table table-striped" id="commentsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Post ID</th>
                                <th>Username</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment): ?>
                                <tr>
                                    <td><?= esc($comment['id']) ?></td>
                                    <td><?= esc($comment['post_id']) ?></td>
                                    <td><?= esc($comment['user_name']) ?></td>
                                    <td><?= esc($comment['comment_text']) ?></td>
                                    <td><?= esc($comment['comment_date']) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/delete-comment/' . $comment['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>