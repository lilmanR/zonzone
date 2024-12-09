<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <!-- Font Awesome -->
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        /* Background Gradient */
        body.bg-gradient-primary {
            background: linear-gradient(to bottom right, #831e1d, #5e0403);
            min-height: 100vh; /* Full screen height */
            display: flex; /* Center content vertically */
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif; /* Clean font */
        }

        /* Card Styling */
        .card {
            border-radius: 15px; /* Rounded corners */
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Heading */
        h1.h4.text-gray-900 {
            color: #5e0403; /* Match gradient theme */
            font-weight: bold;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #831e1d;
            border-color: #831e1d;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #5e0403;
            border-color: #5e0403;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow on hover */
        }

        /* Input Styling */
        .form-control {
            border-radius: 10px; /* Rounded inputs */
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #831e1d; /* Highlight focus */
            box-shadow: 0 0 5px rgba(131, 30, 29, 0.5);
        }

        /* Link Styling */
        a.small {
            color: #831e1d;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a.small:hover {
            color: #5e0403;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <?php if(session()->getFlashdata('msg')): ?>
                                        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
                                    <?php endif; ?>
                                    <form class="user" action="<?= site_url('auth/processRegister') ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="nama_lengkap" class="form-control form-control-user" placeholder="Nama Lengkap" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jurusan">Pilih jurusan anda :</label>
                                            <select id="jurusan" name="jurusan" class="form-control" required>
                                                <option value="FICT">FICT</option>
                                                <option value="FMB">FMB</option>
                                                <option value="FHS">FHS</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" placeholder="Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirm_password" class="form-control form-control-user" placeholder="Repeat Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fprofile">Upload Foto Profil:</label>
                                            <input type="file" name="fprofile" class="form-control-file">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= site_url('login') ?>">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>

</body>
</html>
