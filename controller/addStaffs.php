<?php
include '../config.php';
session_start();
           // Add new staff member
           $pf = mysqli_real_escape_string($connect, $_POST['pf-staff']);
           $rl = mysqli_real_escape_string($connect, $_POST['rl-staff']);
           $fbUrl = mysqli_real_escape_string($connect, $_POST['furl']);
           $fname = mysqli_real_escape_string($connect, $_POST['fname']);
           $lname = mysqli_real_escape_string($connect, $_POST['lname']);
           $gender = mysqli_real_escape_string($connect, $_POST['gender']);
           $bd = mysqli_real_escape_string($connect, $_POST['birthdate']);
           $vil = mysqli_real_escape_string($connect, $_POST['vil']);
           $dist = mysqli_real_escape_string($connect, $_POST['dist']);
           $pro = mysqli_real_escape_string($connect, $_POST['pro']);
           $pnum = mysqli_real_escape_string($connect, $_POST['mobno']);
           $number_other = mysqli_real_escape_string($connect, $_POST['altconno']);
           $email = mysqli_real_escape_string($connect, $_POST['email']);

           $sql = "INSERT INTO tb_staffs (pf_staff, role_staff, facebook_url, fname, lname, gender,birthdate, vil, dist, pro, pnum, number_other, email)  
                    VALUES ('$pf', '$rl', '$fbUrl', '$fname', '$lname', '$gender' , '$bd' , '$vil', '$dist', '$pro', '$pnum', '$number_other', '$email')";


            $result = mysqli_query($connect, $sql);
            if ($result) {
                $_SESSION['success'] = "ບັນທຶກຂໍ້ມູນສຳເລັດ";
            } else {
                $_SESSION['error'] = "ບັນທຶກຂໍ້ມູນຜິດພາດ";
            }
           

       /*  case 'edit':
            // Update student
            $pf = $_POST['pf-staff'];
            $role = $_POST['stdname'];
            $fbUrl = $_POST['stdname'];
            $fname = $_POST['stdname'];
            $lname = $_POST['birthdate'];
            $vil = $_POST['lvil'];
            $dist = $_POST['ldist'];
            $pro = $_POST['bpro'];
            $pnum = $_POST['mobile'];
            $number_other = $_POST['mobile'];

            $sql = "UPDATE tb_student SET 
                        fullName = '$stdname', 
                        bdate = '$birthdate', 
                        lvil = '$lvil', 
                        ldist = '$ldist', 
                        lpro = '$bpro', 
                        mobile = '$mobile'
                    WHERE stID = '$stID'";

            $result = mysqli_query($connect, $sql);
            if ($result) {
                $_SESSION['success_edit'] = "ແກ້ໄຂຂໍ້ມູນສຳເລັດ";
            } else {
                $_SESSION['error'] = "ແກ້ໄຂຂໍ້ມູນຜິດພາດ";
            }
            break;

        case 'delete':
            // Delete student
            $stID = $_POST['id'];

            $sql = "DELETE FROM tb_student WHERE stID = ' $stID' ";

            $result = mysqli_query($connect, $sql);
            if ($result) {
                $_SESSION["success_delete"] = "ລຶບຂໍ້ມູນສຳເລັດ";
            } else {
                $_SESSION['error'] = "ແກ້ໄຂຂໍ້ມູນຜິດພາດ";
            }
            break;
    }
} */

// Redirect to the appropriate page
header("Location: ../Views/user-add.php");
exit();
?>