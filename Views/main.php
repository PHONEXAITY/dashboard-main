<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe Management System</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@100..900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/tecdig.css?v=1.0.0">
</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->
   <!-- SideBar -->
   <?php include './sidebar.php'?>
   <!-- SideBar -->

    <main class="main-content">
        <div class="position-relative">
            <!--Nav Start-->
         <?php include './navbar.php' ?>
            <!--Nav End-->
        </div>
   <!-- Dashboard -->
      <?php include './dashboard.php' ?>
   <!-- Dashboard -->
<!-- footer -->
<?php include './footer.php' ?>
    </main>

    <!-- Wrapper End-->
    <!-- offcanvas start -->

    <!-- Backend Bundle JavaScript -->
    <script src="../assets/js/libs.min.js"></script>
    <!-- widgetchart JavaScript -->
    <script src="../assets/js/charts/widgetcharts.js"></script>
    <!-- mapchart JavaScript -->
    <script src="../assets/js/charts/vectore-chart.js"></script>
    <script src="../assets/js/charts/dashboard.js"></script>
    <!-- fslightbox JavaScript -->
    <script src="../assets/js/fslightbox.js"></script>
    <!-- settings JavaScript -->
    <script src="../assets/js/setting.js"></script>
    <!-- Form Wizard Script -->
    <script src="../assets/js/form-wizard.js"></script>
    <!-- app JavaScript -->
    <script src="../assets/js/app.js"></script>

</body>

</html>