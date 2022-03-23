<?php
        session_start(); 
        include('../config/db.php');
        // ถ้าไม่loginก็จะเข้าหน้านี้ไม่ได้
if(!isset($_SESSION['user_email'])) { 
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_email']);
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title> ฟอร์มแก้ไขสมาชิก </title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>

<body>
    <?php
    include('../config/db.php');
    // ไอดีที่ส่งมาแก้ไข 
    $user_id = $_GET['id'];
    //echo $user_id;
    $query = "SELECT * FROM user_details WHERE user_id=$user_id";
    $result = mysqli_query($conn, $query) or die("Error in sql : $query".
        mysqli_error($conn));
    $row = mysqli_fetch_array($result);
     //print_r($row);
     ?>
    <?php
     // session_start(); 
     include('../config/db.php');
     //2. query ข้อมูลจากตาราง tb_member:
     $queryde = "SELECT * FROM department_info ORDER BY department_id asc" or die("Error:" . mysqli_error());
     //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
     $resultde = mysqli_query($conn, $queryde);
?>
    <?php
     // session_start(); 
     include('../config/db.php');
     //2. query ข้อมูลจากตาราง tb_member:
     $queryper = "SELECT * FROM perdepartment_info ORDER BY perdepartment_id asc" or die("Error:" . mysqli_error());
     //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
     $resultper = mysqli_query($conn, $queryper);
?>



    <!-- <div class="logo-container">
        <div class="logo">
            <img src="../img/kuthai.jpg" alt="logo ku" class="mini-logo">
            <img src="../img/kueng.jpg" alt="logo ku" class="mini-logo-ku">
        </div>
        <div>

        </div>
        <div class="profile-logo">
            <img src="../img/kueng.jpg" alt="logo ku" class="profile">
            <div class="triangleBottom"></div>
        </div>
    </div> -->
    <header>
        <!-- partial:index.partial.html -->
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

        <div class="wrapper">
            <div class="navbar">
                <div class="navbar_left">
                    <div class="logo">
                        <img src="../img/kuthai.jpg" alt="logo ku" class="mini-logo">
                        <img src="../img/kueng.jpg" alt="logo ku" class="mini-logo-ku">
                    </div>
                </div>

                <div class="navbar_right">
                    <div class="profile">
                        <div class="icon_wrap">
                            <img src="<?php echo $row['user_pic']; ?>" alt="profile_pic">
                            <span class="name"><?php echo $row['user_firstname']; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <div class="profile_dd">
                            <ul class="profile_ul">
                                <!-- logged in user information เช็คว่ามีการล็อคอินเข้ามาไหม -->
                                <?php if (isset($_SESSION['email'])) : ?>
                                <?php endif ?>
                                <li class="profile_li"><a class="profile" href="profile.php"><span class="picon"><i
                                                class="fas fa-user-alt"></i>
                                        </span>Profile</a>
                                    <div class="btn">My Account</div>
                                </li>
                                <li><a class="logout" href="home.php?logout='1'"><span class="picon"><i
                                                class="fas fa-sign-out-alt"></i></span>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <script src="script.js"></script>
    </header>
    <header>
        <div class="nav">
            <ul>
                <li class="a"><a href="operation_result.php"> สรุปการดำเนินงาน </a> </li>
                <li class="b"><a href="#"> จัดการบุคลากร </a>
                    <ul>
                        <li><a href="index.php">เพิ่มบุคลากร</a></li>
                        <li><a href="edituser.php">แก้ไข/ลบ บุคลากร</a></li>
                    </ul>
                </li>
                <li class="c"><a href="project_manage.php"> จัดการโครงการ </a> </li>
                <li class="d"><a href="project_detail.php"> จัดการรายละเอียดโครงการ </a> </li>
            </ul>
        </div>
    </header>


    <p>&nbsp&nbsp<span class="material-icons">edit</span>แก้ไขบุคลากร</p>
    <form action="addUserEdit_db.php" method="post">
        <?php include('errors.php'); ?>
        <?php if (isset($_SESSION['error'])) : ?>
        <div class="error">
            <h3>
                <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                ?>
            </h3>
        </div>
        <?php endif ?>
        <div class="grid-container">
            <div class="grid-item">
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> ID:</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="id" required value="<?php echo $row['user_id'];?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> ชื่อ:</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="firstname" required value="<?php echo $row['user_firstname'];?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> นามสกุล:</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="lastname" required value="<?php echo $row['user_lastname'];?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> เพศ:</label>
                    </div>
                    <div class="col-75">
                        <select name="type_sex" required>

                            <option value="M"> ชาย
                                <?php if($row["user_typeSex"]=="M")//{ echo " selected ";}//end if์?>

                            </option>
                            <option value="F"> หญิง
                                <?php if($row["user_typeSex"]=="F")//{ echo " selected  ";}//end if์?>

                            </option>

                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> ตำแหน่ง:</label>
                    </div>
                    <div class="col-75">
                        <select name="position" required>
                            <?php
    include('../config/db.php');
    // ไอดีที่ส่งมาแก้ไข 
    $perdepartment_id = $_GET['id2'];
    //echo $user_id;
    $queryper = "SELECT * FROM perdepartment_info ORDER BY perdepartment_id asc" or die("Error:" . mysqli_error());
     //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
     $resultper = mysqli_query($conn, $queryper);
   while ($rowper = mysqli_fetch_array($resultper)) {
      ?>


                            <option value="<?=$rowper["perdepartment_name"]?>"
                                <?php if($row["user_position"]==$rowper["perdepartment_name"]){echo " selected ";}//end if?>>
                                <?=$rowper["perdepartment_name"]?>
                            </option>


                            <?php
                            }//end while  
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="department"> แผนก:</label>
                    </div>
                    <div class="col-75">
                        <select name="department" required>

                            <?php
    include('../config/db.php');
    // ไอดีที่ส่งมาแก้ไข 
    $department_id = $_GET['id3'];
    //echo $user_id;
    $queryde = "SELECT * FROM department_info ORDER BY department_id asc" or die("Error:" . mysqli_error());
     //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
     $resultde = mysqli_query($conn, $queryde);
   while ($rowde = mysqli_fetch_array($resultde)) {
      ?>
                            <option value="<?=$rowde["department_name"]?>"
                                <?php if($row["user_department"]==$rowde["department_name"]){echo " selected ";}//end if?>>
                                <?=$rowde["department_name"]?>
                            </option>


                            <?php
                            }//end while  
                            ?>


                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> โทรศัพท์:</label>
                    </div>
                    <div class="col-75">
                        <input type="number" name="tel" placeholder="0xx-xxx-xxxx" required
                            value="<?php echo $row['user_phone'];?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> E-mail:</label>
                    </div>
                    <div class="col-75">
                        <input type="email" name="email" placeholder="sample@gmail.com" required
                            value="<?php echo $row['user_email'];?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> password:</label>
                    </div>
                    <div class="col-75">
                        <input type="password" name="password" required value="<?php echo $row['user_password'];?> "
                            autocomplete="current-password" id="id_password">
                        <i class="far fa-eye" id="togglePassword" style="margin-left: 30px; cursor: pointer;"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> สถานะผู้ใช้งาน:</label>
                    </div>
                    <div class="col-75">
                        <select name="type_user" required value="<?php echo $row['user_status'];?>">

                            <option value="1"> แอดมิน </option>
                            <option value="2"> บุคลากร </option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="grid-item-center">
                <img id="output" src="../img/profile.png" class="show-profile" />
                <div>
                    <label style="padding: 8px 0;display: inline-table;margin-top: 10px;" for="file-upload"
                        class="custom-file-upload">แนบไฟล์</label>
                    <input id="file-upload" name="fileToUpload" type="file" accept="image/*"
                        onchange="loadFile(event)" />
                    <!-- แสดงรูปที่เลือก -->
                    <input id="profile_Upload" name="profile_Upload" type="text" style="display:none;" />
                    <script>
                    var loadFile = function(event) {
                        let base64String = " ";
                        var reader = new FileReader();
                        reader.onload = function() {
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        // imageUploaded
                        var file = document.querySelector('input[type=file]')['files'][0];

                        reader.onload = function() {
                            base64String = reader.result;
                            document.getElementById("profile_Upload").value = base64String;
                            output.src = reader.result;
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    }

                    function displayString() {
                        console.log("Base64String about to be printed");
                        alert(base64String);
                    }
                    </script>
                </div>
            </div>
            <div class="container-button">
                <button type="reset" value="reset" class="backButton" onclick="parent.location='edituser.php'">Back
                </button>
                <button type="submit" name="Update_User" class="summitButton">Submit</button>
            </div>
        </div>
    </form>
    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#id_password');
    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>

</html>