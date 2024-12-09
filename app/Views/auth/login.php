<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Fonts and CSS from SB Admin 2 -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        /* Background Gradient */
        body.bg-gradient-primary {
            background: linear-gradient(to right, #831e1d, #5e0403);
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

        /* Custom background image on left side (optional) */
        .bg-login-image {
            background: url('<?= base_url('img/login-image.png') ?>') center center no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <!-- Left side with optional image -->
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <!-- Right side for login form -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <!-- Flash Message -->
                                    <?php if(session()->getFlashdata('msg')): ?>
                                        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                                    <?php endif; ?>
                                    <!-- Login Form -->
                                    <form action="<?= site_url('auth/processLogin') ?>" method="post" class="user">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= site_url('register') ?>">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript from SB Admin 2 -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
