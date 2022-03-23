<?php
    include('check_login.php');
    include('../config/db.php');
//    include('../config/db.php');
    $project_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM project_info 
JOIN user_details
    ON user_details.user_id=project_info.user_id
WHERE project_info.project_id=$project_id";
    $result = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
    $row = mysqli_fetch_array($result);

    $sqlRevision = "SELECT * FROM project_revision where project_id={$project_id}";
    $revision = mysqli_query($conn, $sqlRevision) or die("Error in sql : $query". mysqli_error($conn));
    if(!empty($revision) && $revision->num_rows > 0) {
        $revision = iterator_to_array($revision)[0];
    }
    $query = "SELECT * FROM user_details WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query) or die("Error in sql : $query" . mysqli_error($conn));
    $row = mysqli_fetch_array($result);
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
    <link href="css/project_edit.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css?v=<?php echo time(); ?>">

    <!-- plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body>

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
    <p>&nbsp&nbsp<span class="material-icons">assignment</span>จัดการโครงการ/<span
            class="material-icons">upload_file</span>แก้ไขรายละเอียดโครงการ</p>


    <div class="grid-edit">
        <div class="grid-item">
            <br>
            <a href="project_manage_edit.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="project_manage_edit_performance.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspรายงานผลการดำเนินงาน&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br>
            <br>
            <a href="project_manage_edit_adjust_project.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติปรับแผนโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="project_manage_edit_disbursement.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติเบิกจ่ายรายครั้ง&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="project_manage_edit_close_project.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติปิดโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp

        </div>
        <div class="grid-item-line">
            <form action="adjust_db.php" method="post">
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
                <div class="grid-item">
                    <div class="row">
                        <h3>
                            ขออนุมัติปรับแผนปฏิบัติการประจำปี
                        </h3>
                    </div>
                    <div class="row">

                        <div class="col-25">
                            <label for="โครงการ" class="topic">โครงการ:</label>
                        </div>

                        <div class="col-65">
                            <input type="hidden" class="inputFill-Information" name="project_id"
                                value="<?php echo $row['project_id'];?>">
                            <input type="text" class="inputFill-Information" name="project_name" required
                                value="<?php echo $row['project_name'];?>" readonly>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label class="topic" for="project_fiscal_year"> ตามแผนปฏิบัติการประจำปีงบประมาณ
                                พ.ศ.:</label>
                        </div>
                        <div class="col-65">
                            <select name="project_fiscal_year" class="inputFill-Information mt-30" required>
                                <?php for($i=$row['project_fiscal_year'];$row['project_fiscal_year'] - $i <= 4;$i--): ?>
                                <option value="<?php echo $i ?>"><?php echo $i?></option>
                                <?php   endfor ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label class="topic" for="project_fiscal_year"> ปรับแผนงบประมาณ ครั้งที่ :</label>
                        </div>
                        <div class="col-65">
                            <input type="number" min="1" name="revision_number"
                                value="<?php if(!empty($revision['revision_number'])) echo $revision['revision_number'] ?>"
                                required>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะโครงการ : " class="topic">ผู้รับผิดชอบโครงการ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="responsible_man"
                                value="<?php echo $row["user_firstname"]; ?> &nbsp; <?php echo $row["user_lastname"] ?>"
                                class="inputFill-Information" readonly>
                        </div>
                    </div>
                    <div class="container-button">
                        <button type="reset" value="reset" class="backButton" onclick="parent.location='home.php'">Back
                        </button>
                        <button type="submit" name="adjust_edit" class="summitButton">Submit</button>
                    </div>
                </div>


        </div>

    </div>
</body>

</html>