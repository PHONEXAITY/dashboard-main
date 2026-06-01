<?php
require_once __DIR__ . '/../includes/auth.php';
if (is_logged_in()) {
    header('Location: main.php');
    exit();
}
$err = flash_get('login_error');
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SMS - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@100..900&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/tecdig.css?v=1.0.0">
    <style>body{font-family:'Noto Sans Lao',sans-serif}</style>
</head>

<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <div id="loading">
        <div class="loader simple-loader"><div class="loader-body"></div></div>
    </div>

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <a href="#" class="navbar-brand d-flex align-items-center mb-3">
                                        <img src="../assets/logo.png" class="sidebar-color-logo" width="80">
                                        <h3 class="logo-title ms-2 text-primary">SMS</h3>
                                    </a>
                                    <h2 class="mb-2 text-center">ເຂົ້າສູ່ລະບົບ</h2>
                                    <p class="text-center">ກະລຸນາເຂົ້າສູ່ລະບົບເພື່ອໃຊ້ງານ</p>
                                    <?php if ($err): ?>
                                    <div class="alert alert-danger" role="alert"><?= e($err) ?></div>
                                    <?php endif; ?>
                                    <form method="post" action="../controller/login.php">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="username" class="form-label">ຊື່ຜູ້ໃຊ້</label>
                                                    <input type="text" name="username" class="form-control" id="username" placeholder="admin / staff" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">ລະຫັດຜ່ານ</label>
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="••••••" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary px-5">ເຂົ້າສູ່ລະບົບ</button>
                                        </div>
                                        <p class="mt-3 text-center text-muted small">
                                            ບັນຊີທົດລອງ: <code>admin / admin123</code> &nbsp;|&nbsp; <code>staff / staff123</code>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex d-md-block d-none justify-content-center bg-soft-secondary p-0 mt-n1 vh-100">
                    <img src="../assets/images/auth/01.png" class="img-fluid" alt="images">
                </div>
            </div>
        </section>
    </div>

    <script src="../assets/js/libs.min.js"></script>
    <script src="../assets/js/app.js"></script>
</body>
</html>
