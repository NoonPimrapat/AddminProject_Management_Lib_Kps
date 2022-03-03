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
        //2. query ข้อมูลจากตาราง tb_member:
        $query = "SELECT * FROM department_info ORDER BY department_id asc" or die("Error:" . mysqli_error());
        //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
        $result = mysqli_query($conn, $query);

       
    
        //2. query ข้อมูลจากตาราง tb_member:
        $query2 = "SELECT * FROM perdepartment_info ORDER BY perdepartment_id asc" or die("Error:" . mysqli_error());
        //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
        $result2 = mysqli_query($conn, $query2);
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
    <title> Minimal Dropdown Menu</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>

<body>
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
                            <img src="../img/kueng.jpg" alt="profile_pic">
                            <span class="name"><?php echo $_SESSION['user_email'];?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <div class="profile_dd">
                            <ul class="profile_ul">
                                <!-- logged in user information เช็คว่ามีการล็อคอินเข้ามาไหม -->
                                <?php if (isset($_SESSION['email'])) :?>
                                <?php endif?>
                                <li class="profile_li"><a class="profile" href="profile.php"><span class="picon"><i
                                                class="fas fa-user-alt"></i>
                                        </span>Profile</a>
                                    <div class="btn">My Account</div>
                                </li>

                                <li><a class="logout" href="login.php?logout='1'"><span class="picon"><i
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


    <p>&nbsp&nbsp<span class="material-icons">manage_accounts</span>จัดการบุคคลากร/<span
            class="material-icons">person_add_alt_1</span>เพิ่มบุคคลากร</p>
    <form action="addUser_db.php" method="post">
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
                        <label for="fname"> ชื่อ:</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="firstname" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> นามสกุล:</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="lastname" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> เพศ:</label>
                    </div>
                    <div class="col-75">
                        <select name="type_sex" required>
                            <option value=""> กรุณาเลือก </option>
                            <option value="M"> ชาย </option>
                            <option value="F"> หญิง </option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> ตำแหน่ง:</label>
                    </div>
                    <div class="col-75">
                        <select name="position" required>
                            <option value=""> กรุณาเลือก </option>
                            <?php foreach($result2 as $results2){?>
                            <option value="<?php echo $results2["perdepartment_name"];?>">
                                <?php echo $results2["perdepartment_name"]; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="department"> แผนก:</label>
                    </div>
                    <div class="col-75">
                        <select name="department" required>
                            <option value=""> กรุณาเลือก </option>
                            <?php foreach($result as $results){?>
                            <option value="<?php echo $results["department_name"];?>">
                                <?php echo $results["department_name"]; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> โทรศัพท์:</label>
                    </div>
                    <div class="col-75">
                        <input type="number" name="tel" placeholder="0xx-xxx-xxxx" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> E-mail:</label>
                    </div>
                    <div class="col-75">
                        <input type="email" name="email" placeholder="sample@gmail.com" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> password:</label>
                    </div>
                    <div class="col-75">
                        <input type="password" name="password" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> สถานะผู้ใช้งาน:</label>
                    </div>
                    <div class="col-75">
                        <select name="type_user" required>
                            <option value=""> กรุณาเลือก </option>
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
                <button type="reset" value="reset" class="backButton" onclick="parent.location='index.php'">Back
                </button>
                <button type="submit" name="Add_User" class="summitButton">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>