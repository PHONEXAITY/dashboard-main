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

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/tecdig.css?v=1.0.0">
</head>

<body class="">
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
        <div class="conatiner-fluid content-inner mt-5 py-0" style="font-family: Noto Sans Lao ">
            <div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">ລາຍຊື່ ພະນັກງານທັງໝົດ</h4>
                                </div>
                            </div>
                            <div class="card-body px-0">
                                <div class="table-responsive">
                                    <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                                        <thead>
                                            <tr class="ligth">
                                                <th>ໂປຣໄຟລ໌</th>
                                                <th>ຊື່ແລະນາມສະກຸນ</th>
                                                <th>ວັນເດືອນປີເກີດ</th>
                                                <th>ຊ່ອງທາງການຕິດຕໍ່</th>
                                                <th>ອີເມວ</th>
                                                <th>ບ້ານຢູ່ປັດຈຸບັນ</th>
                                                <th>ເມືອງ</th>
                                                <th>ແຂວງ</th>
                                                <th>ຕຳແໜ່ງ</th>
                                                <th style="min-width: 100px">ການຈັດການ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php   
                                             $sql = "SELECT * FROM tb_staffs";
                                             $result = mysqli_query($connect, $sql);
                                             if (mysqli_num_rows($result) > 0) {
                                              while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                            <tr>
                                            <td>
                                               <img src="<?php echo $row['pf_staff']; ?>" alt="Profile Image" class="rounded avatar-40 me-3">
                                              </td>
                                                <td><?php echo $row['fname']; ?></td>
                                                <td><?php echo $row['birthdate']; ?></td>
                                                <td><?php echo $row['pnum']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['vil']; ?></td>
                                                <td><?php echo $row['dist']; ?></td>
                                                <td><?php echo $row['pro']; ?></td>
                                                <td><?php echo $row['role_staff']; ?></td>
                                                <td>
                                                    <div class="flex align-items-center list-user-action">
                                                      <!--   <a class="btn btn-sm btn-icon " data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                            <span class="btn-inner">
                                                                <img src="../assets/img/user.svg" alt="">
                                                            </span>
                                                        </a> -->
                                                        <a class="btn btn-sm btn-icon " data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $row['id']; ?>">
                                                            <span class="btn-inner">
                                                            <img src="../assets/img/edit (1).png" alt="" width="28">
                                                            </span>
                                                        </a>
                                                        <a class="btn btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                            <span class="btn-inner">
                                                            <img src="../assets/img/trash-bin.png" alt="" width="28">
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <!-- View Modal -->
                                                 <!--    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewModalLabel">View Staff Member</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group d-flex justify-content-center align-items-center">
                                                                        <div class="profile-img-edit position-relative">
                                                                            <img class="profile-pic rounded avatar-130" src="<?php echo $row['pf_staff']; ?>" alt="profile-pic" name="pf-staff">
                                                                        </div>
                                                                    </div>

                                                                    <label class="form-label">ຕຳແໜ່ງ:</label>
                                                                    <p class="form-control" id="role_staff"><?php echo $row['role_staff']; ?></p>

                                                                    <label class="form-label" for="furl">Facebook Url:</label>
                                                                    <p class="form-control" id="furl"><?php echo $row['facebook_url']; ?></p>

                                                                    <div class="row">
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="fname">ຊື່:</label>
                                                                            <p class="form-control" id="fname"><?php echo $row['fname']; ?></p>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="lname">ນາມສະກຸນ:</label>
                                                                            <p class="form-control" id="lname"><?php echo $row['lname']; ?></p>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="gender">ເພດ:</label>
                                                                            <p class="form-control" id="gender"><?php echo $row['gender']; ?></p>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="birthdate">ວັນເດືອນປີເກີດ:</label>
                                                                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $row['birthdate']; ?>" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="vil">ບ້ານຢູ່ປັດຈຸບັນ:</label>
                                                                            <input type="text" class="form-control" id="vil" name="vil" value="<?php echo $row['vil']; ?>" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="dist">ເມືອງ:</label>
                                                                            <input type="text" class="form-control" id="dist" name="dist" value="<?php echo $row['dist']; ?>" required>
                                                                        </div>
                                                                        <div class="form-group col-sm-12">
                                                                            <label class="form-label">ແຂວງ:</label>
                                                                            <p class="form-control" id="pro"><?php echo $row['pro']; ?></p>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="mobno">ເບີໂທຕິດຕໍ່:</label>
                                                                            <input type="text" class="form-control" id="mobno" name="mobno" value="<?php echo $row['pnum']; ?>" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="altconno">ຊ່ອງທາງຕິດຕໍ່ອື່ນ:</label>
                                                                            <input type="text" class="form-control" id="altconno" name="altconno" value="<?php echo $row['number_other']; ?>" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label" for="email">ອີເມວ:</label>
                                                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel">ລຶບຂໍໍ້ມູນພະນັກງານ</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>ທ່ານແນ່ໃຈລະບໍວ່າຕ້ອງການລຶບບຸກຄົນນີ້ ?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ປິດ</button>
                                                                    <button type="button" class="btn btn-danger">ລຶບ</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                              <!-- Edit Modal -->
                                                        <div class="modal fade" id="editModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editModalLabel">ແກ້ໄຂຂໍ້ມູນພະນັກງານ</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="editForm" method="POST" action="../controller/editStaffs.php">
                                                                            <!-- Input fields for editing staff member details -->
                                                                            <div class="form-group d-flex justify-content-center align-items-center">
                                                                            <div class="profile-img-edit position-relative">
                                                                                <img class="profile-pic rounded avatar-130" src="<?php echo $row['pf_staff']; ?>" alt="profile-pic" name="pf-staff">
                                                                                <div class="upload-icone bg-primary ms-5">
                                                                                    <svg class="upload-button" width="14" height="14" viewBox="0 0 24 24">
                                                                                        <path fill="#ffffff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                                                                    </svg>
                                                                                    <input class="file-upload" type="file" accept="image/*" name="pf-staff" id="pf-staff">
                                                                                </div>
                                                                            </div>
                                                                            </div>

                                                                            <label class="form-label">ຕຳແໜ່ງ:</label>
                                                                            <select class="selectpicker form-control" data-style="py-0" name="rl-staff" id="rl-staff"  required>
                                                                                <option value="" disabled selected><?php echo $row['role_staff']; ?></option>
                                                                                <option>ຜູ້ຈັດການ</option>
                                                                                <option>ພະນັກງານຂາຍ</option>
                                                                                <option>ແມ່ຄົວ</option>
                                                                                <option>ພະນັກງານເສີບ</option>
                                                                            </select>
                                                                            <label class="form-label" for="furl">Facebook Url:</label>
                                                                            <input type="text" class="form-control" id="furl" name="furl" placeholder="ລີ້ງເຟສບຸກ (ທາງເລືອກ)" value="<?php echo $row['facebook_url']; ?>">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="fname">ຊື່:</label>
                                                                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="ປ້ອນຊື່ຂອງທ່ານ" value="<?php echo $row['fname']; ?>" required>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="lname">ນາມສະກຸນ:</label>
                                                                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="ປ້ອນນາມສະກຸນຂອງທ່ານ" value="<?php echo $row['lname']; ?>" required>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="gender">ເພດ:</label>
                                                                                    <select class="selectpicker form-control" id="gender" name="gender" data-style="py-0"  required>
                                                                                        <option value="" disabled selected><?php echo $row['gender']; ?></option>
                                                                                        <option value="Male">ຊາຍ</option>
                                                                                        <option value="Female">ຍິງ</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="birthdate">ວັນເດືອນປີເກີດ:</label>
                                                                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $row['birthdate']; ?>" required>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="add1">ບ້ານຢູ່ປັດຈຸບັນ</label>
                                                                                    <input type="text" class="form-control" id="vil" name="vil" placeholder="ປ້ອນບ້ານຢູ່ຂອງທ່ານ" value="<?php echo $row['vil']; ?>" required>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="add2">ເມືອງ</label>
                                                                                    <input type="text" class="form-control" id="dist" name="dist" placeholder="ປ້ອນເມືອງຂອງທ່ານ" value="<?php echo $row['dist']; ?>" required>
                                                                                </div>
                                                                                <div class="form-group col-sm-12">
                                                                                    <label class="form-label">ແຂວງ:</label>
                                                                                    <select class="selectpicker form-control" id="pro" name="pro" data-style="py-0" required>
                                                                                        <option value="" disabled selected><?php echo $row['pro']; ?></option>
                                                                                        <option>ນະຄອນຫຼວງວຽງຈັນ</option>
                                                                                        <option>ຫຼວງພະບາງ</option>
                                                                                        <option>ຊຽງຂວາງ</option>
                                                                                        <option>ວຽງຈັນ</option>
                                                                                        <option>ອຸດົມໄຊ</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="mobno">ເບີໂທຕິດຕໍ່</label>
                                                                                    <input type="text" class="form-control" id="mobno" name="mobno" placeholder="ເບີໂທລະສັບຂອງທ່ານ" value="<?php echo $row['pnum']; ?>" required>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="altconno">ຊ່ອງທາງຕິດຕໍ່ອື່ນ</label>
                                                                                    <input type="text" class="form-control" id="altconno" name="altconno" placeholder="ຊ່ອງທາງການຕິດຕໍ່ອື່ນ" value="<?php echo $row['number_other']; ?>" required>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="form-label" for="email">ອີເມວ:</label>
                                                                                    <input type="email" class="form-control" id="email" name="email" placeholder="ໃ່ສ່ອີເມວ" value="<?php echo $row['email']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ຍົກເລີກ</button>
                                                                        <button type="button" class="btn btn-primary" onclick="saveChanges()">ບັນທຶກ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            } else {
                                              
                                                ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">No data available</td>
                                                </tr>
                                                <?php
                                            }
                                            mysqli_free_result($result);
                                          ?>
                                        </tbody>
                                    </table>
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