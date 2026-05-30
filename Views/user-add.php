<?php
include '../config.php';
session_start();
?>

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
  <!-- SweetAlert2-->
  <script src="dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/tecdig.css?v=1.0.0">
</head>
<style>
    .profile-pic {
        width: auto; 
    height: auto; 
    max-width: 100px; 
    max-height: 100px; 
    object-fit: cover;
    object-position: center; 
}
.notosanslao {
    font-family: 'Noto Sans Lao', sans-serif !important;
}
</style>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->
  <?php include './sidebar.php' ?>
    <main class="main-content">
        <div class="position-relative">
            <!--Nav Start-->
<?php include './navbar.php' ?>
            <!--Nav End-->
        </div>
        <div class="container-fluid content-inner mt-5 py-0" style="font-family: Noto Sans Lao ">
            <div>
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">ເພີ່ມພະນັກງານໃໝ່</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="../controller/addStaffs.php">
                                    <div class="form-group">
                                        <div class="profile-img-edit position-relative">
                                            <img class="profile-pic rounded avatar-100" src="../assets/images/avatars/01.png" alt="profile-pic" name="pf-staff">
                                            <div class="upload-icone bg-primary">
                                                <svg class="upload-button" width="14" height="14" viewBox="0 0 24 24">
                                                    <path fill="#ffffff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                                </svg>
                                                <input class="file-upload" type="file" accept="image/*" name="pf-staff" id="pf-staff">
                                            </div>
                                        </div>
                                        <div class="img-extension mt-3">
                                            <div class="d-inline-block align-items-center">
                                                <span>ປະເພດຮູບຕ້ອງເປັນ :</span>
                                                <a href="javascript:void();">.jpg</a>
                                                <a href="javascript:void();">.png</a>
                                                <a href="javascript:void();">.jpeg</a>
                                                <span>ຈື່ງສາມາດຮັບຮອງ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">ຕຳແໜ່ງ:</label>
                                        <select class="selectpicker form-control" data-style="py-0" name="rl-staff" id="rl-staff" required>
                                            <option value="" disabled selected>ເລືອກຕຳແໜ່ງທີ່ສັງກັດ</option>
                                            <option>ຜູ້ຈັດການ</option>
                                            <option>ພະນັກງານຂາຍ</option>
                                            <option>ແມ່ຄົວ</option>
                                            <option>ພະນັກງານເສີບ</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="furl">Facebook Url:</label>
                                        <input type="text" class="form-control" id="furl" name="furl" placeholder="ລີ້ງເຟສບຸກ (ທາງເລືອກ)">
                                    </div>
                                   
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">ຂໍ້ມູນລາຍລະອຽດ</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="new-user-info">
                                  <!--   <form method="POST" action="../controller/addStaffs.php"> -->
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="fname">ຊື່:</label>
                                                <input type="text" class="form-control" id="fname" name="fname" placeholder="ປ້ອນຊື່ຂອງທ່ານ" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="lname">ນາມສະກຸນ:</label>
                                                <input type="text" class="form-control" id="lname" name="lname" placeholder="ປ້ອນນາມສະກຸນຂອງທ່ານ" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="gender">ເພດ:</label>
                                                <select class="selectpicker form-control" id="gender" name="gender" data-style="py-0" required>
                                                    <option value="" disabled selected>ເລືອກເພດ</option>
                                                    <option value="Male">ຊາຍ</option>
                                                    <option value="Female">ຍິງ</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="birthdate">ວັນເດືອນປີເກີດ:</label>
                                                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="add1">ບ້ານຢູ່ປັດຈຸບັນ</label>
                                                <input type="text" class="form-control" id="vil" name="vil" placeholder="ປ້ອນບ້ານຢູ່ຂອງທ່ານ" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="add2">ເມືອງ</label>
                                                <input type="text" class="form-control" id="dist" name="dist" placeholder="ປ້ອນເມືອງຂອງທ່ານ" required>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="form-label">ແຂວງ:</label>
                                                <select class="selectpicker form-control" id="pro" name="pro" data-style="py-0" required>
                                                    <option value="" disabled selected>ກະລຸນາເລືອກແຂວງ</option>
                                                    <option>ນະຄອນຫຼວງວຽງຈັນ</option>
                                                    <option>ຫຼວງພະບາງ</option>
                                                    <option>ຊຽງຂວາງ</option>
                                                    <option>ວຽງຈັນ</option>
                                                    <option>ອຸດົມໄຊ</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="mobno">ເບີໂທຕິດຕໍ່</label>
                                                <input type="text" class="form-control" id="mobno" name="mobno" placeholder="ເບີໂທລະສັບຂອງທ່ານ" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="altconno">ຊ່ອງທາງຕິດຕໍ່ອື່ນ</label>
                                                <input type="text" class="form-control" id="altconno" name="altconno" placeholder="ຊ່ອງທາງການຕິດຕໍ່ອື່ນ" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="email">ອີເມວ:</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="ໃ່ສ່ອີເມວ" required>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        <button type="submit" class="btn btn-primary ">ເພີ່ມ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php include './footer.php'?>
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

<?php
if (isset($_SESSION["success"])) {
    echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ',
              customClass: {
                title: 'notosanslao' 
              }
            });
          </script>";
    unset($_SESSION['success']);
}
elseif (isset($_SESSION["success_delete"])) {
    echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'ລຶບຂໍ້ມູນສຳເລັດແລ້ວ'
            });
          </script>";
    unset($_SESSION['success_delete']);
}
elseif (isset($_SESSION["success_edit"])) {
    echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'ແກ້ໄຂຂໍ້ມູນສຳເລັດແລ້ວ'
            });
          </script>";
    unset($_SESSION['success_edit']);
}
?>